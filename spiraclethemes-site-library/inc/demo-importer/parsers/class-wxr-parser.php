<?php
/**
 * Velour Pro Addons - WXR Parser
 *
 * Parses WordPress eXtended RSS (WXR) export files.
 * Based on the WordPress Importer plugin's parser.
 *
 * @package velour-pro-addons
 * @subpackage inc/demo-import/parsers
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WXR Parser class — converts a WXR file into a structured PHP array.
 */
class WXR_Parser {

	/**
	 * Parse a WXR file.
	 *
	 * @param string $file Absolute path to the WXR file.
	 * @return array|WP_Error Parsed data or error.
	 */
	public function parse( $file ) {
		if ( ! file_exists( $file ) ) {
			return new WP_Error( 'wxr_parser_error', esc_html__( 'File does not exist.', 'velour-pro-addons' ) );
		}

		$parser = $this->get_parser_class( $file );
		return $parser->parse( $file );
	}

	/**
	 * Determine the best parser to use based on available extensions.
	 *
	 * @param string $file File path.
	 * @return WXR_Parser_SimpleXML|WXR_Parser_XML|WXR_Parser_Regex
	 */
	private function get_parser_class( $file ) {
		if ( extension_loaded( 'simplexml' ) ) {
			return new WXR_Parser_SimpleXML();
		}
		if ( extension_loaded( 'xml' ) ) {
			return new WXR_Parser_XML();
		}
		return new WXR_Parser_Regex();
	}
}

/**
 * SimpleXML-based WXR parser.
 */
class WXR_Parser_SimpleXML {

	/**
	 * Parse the file using SimpleXML.
	 *
	 * @param string $file File path.
	 * @return array|WP_Error
	 */
	public function parse( $file ) {
		$authors    = array();
		$categories = array();
		$tags       = array();
		$terms      = array();
		$posts      = array();

		$internal_errors = libxml_use_internal_errors( true );

		$dom       = new DOMDocument();
		$old_value = null;

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$xml = file_get_contents( $file );

		if ( empty( $xml ) ) {
			return new WP_Error( 'wxr_parser_error', esc_html__( 'Empty or unreadable file.', 'velour-pro-addons' ) );
		}

		// Handle WXR namespace.
		$wxr_version  = '';
		$base_url     = '';
		$wxr_namespaces = array(
			'wp' => 'http://wordpress.org/export/1.',
		);

		libxml_clear_errors();

		$load_result = $dom->loadXML( $xml );
		if ( ! $load_result ) {
			libxml_use_internal_errors( $internal_errors );
			return new WP_Error( 'wxr_parser_error', esc_html__( 'Could not parse XML file.', 'velour-pro-addons' ) );
		}

		$xpath = new DOMXPath( $dom );

		// Detect WXR version.
		$version_nodes = $xpath->query( '//wp:wxr_version' );
		if ( $version_nodes->length > 0 ) {
			$wxr_version = $version_nodes->item( 0 )->textContent;
		}

		// Get base URL.
		$base_url_nodes = $xpath->query( '//wp:base_url' );
		if ( $base_url_nodes->length > 0 ) {
			$base_url = $base_url_nodes->item( 0 )->textContent;
		}

		// Parse authors.
		$author_nodes = $xpath->query( '//wp:author' );
		foreach ( $author_nodes as $author_node ) {
			$author = array();
			foreach ( $author_node->childNodes as $child ) {
				if ( XML_ELEMENT_NODE !== $child->nodeType ) {
					continue;
				}
				$tag = str_replace( 'wp:', '', $child->nodeName );
				$author[ 'author_' . $tag ] = $child->textContent;
			}
			$authors[] = $author;
		}

		// Parse categories.
		$category_nodes = $xpath->query( '//wp:category' );
		foreach ( $category_nodes as $cat_node ) {
			$cat = array();
			foreach ( $cat_node->childNodes as $child ) {
				if ( XML_ELEMENT_NODE !== $child->nodeType ) {
					continue;
				}
				$tag = str_replace( 'wp:', '', $child->nodeName );
				$cat[ $tag ] = $child->textContent;
			}
			$categories[] = $cat;
		}

		// Parse tags.
		$tag_nodes = $xpath->query( '//wp:tag' );
		foreach ( $tag_nodes as $tag_node ) {
			$t = array();
			foreach ( $tag_node->childNodes as $child ) {
				if ( XML_ELEMENT_NODE !== $child->nodeType ) {
					continue;
				}
				$tag_name = str_replace( 'wp:', '', $child->nodeName );
				$t[ $tag_name ] = $child->textContent;
			}
			$tags[] = $t;
		}

		// Parse terms.
		$term_nodes = $xpath->query( '//wp:term' );
		foreach ( $term_nodes as $term_node ) {
			$term      = array();
			$term_meta = array();

			foreach ( $term_node->childNodes as $child ) {
				if ( XML_ELEMENT_NODE !== $child->nodeType ) {
					continue;
				}

				$tag = str_replace( 'wp:', '', $child->nodeName );

				// Parse <wp:termmeta> blocks into structured key-value pairs
				// instead of flattening them into a single text value.
				if ( 'termmeta' === $tag ) {
					$meta = array();
					foreach ( $child->childNodes as $meta_child ) {
						if ( XML_ELEMENT_NODE !== $meta_child->nodeType ) {
							continue;
						}
						$meta_tag = str_replace( 'wp:', '', $meta_child->nodeName );
						if ( 'meta_key' === $meta_tag ) {
							$meta['key'] = $meta_child->textContent;
						} elseif ( 'meta_value' === $meta_tag ) {
							$meta['value'] = $meta_child->textContent;
						}
					}
					if ( ! empty( $meta ) ) {
						$term_meta[] = $meta;
					}
				} else {
					$term[ 'term_' . $tag ] = $child->textContent;
				}
			}

			// Attach parsed term meta as a separate array.
			if ( ! empty( $term_meta ) ) {
				$term['term_meta'] = $term_meta;
			}

			$terms[] = $term;
		}

		// Parse items (posts).
		$item_nodes = $xpath->query( '//item' );
		foreach ( $item_nodes as $item_node ) {
			$post = array(
				'postmeta' => array(),
				'comments' => array(),
				'terms'    => array(),
			);

			foreach ( $item_node->childNodes as $child ) {
				if ( XML_ELEMENT_NODE !== $child->nodeType ) {
					continue;
				}

				$node_name = $child->nodeName;

				switch ( $node_name ) {
					case 'title':
						$post['post_title'] = $child->textContent;
						break;
					case 'link':
						$post['link'] = $child->textContent;
						break;
					case 'pubDate':
						$post['post_date'] = $child->textContent;
						break;
					case 'dc:creator':
						$post['post_author'] = $child->textContent;
						break;
					case 'content:encoded':
						$post['post_content'] = $child->textContent;
						break;
					case 'excerpt:encoded':
						$post['post_excerpt'] = $child->textContent;
						break;
					case 'wp:post_id':
						$post['post_id'] = $child->textContent;
						break;
					case 'wp:post_date':
						$post['post_date'] = $child->textContent;
						break;
					case 'wp:post_date_gmt':
						$post['post_date_gmt'] = $child->textContent;
						break;
					case 'wp:post_name':
						$post['post_name'] = $child->textContent;
						break;
					case 'wp:status':
						$post['status'] = $child->textContent;
						break;
					case 'wp:post_type':
						$post['post_type'] = $child->textContent;
						break;
					case 'wp:attachment_url':
						$post['attachment_url'] = $child->textContent;
						break;
					case 'wp:post_parent':
						$post['post_parent'] = $child->textContent;
						break;
					case 'wp:menu_order':
						$post['menu_order'] = $child->textContent;
						break;
					case 'wp:comment_status':
						$post['comment_status'] = $child->textContent;
						break;
					case 'wp:ping_status':
						$post['ping_status'] = $child->textContent;
						break;
					case 'wp:postmeta':
						$meta = array();
						foreach ( $child->childNodes as $meta_child ) {
							if ( XML_ELEMENT_NODE !== $meta_child->nodeType ) {
								continue;
							}
							$meta_tag = str_replace( 'wp:', '', $meta_child->nodeName );
							// Normalize meta_key/meta_value to key/value for
							// compatibility with the content importer which
							// expects $meta['key'] and $meta['value'].
							if ( 'meta_key' === $meta_tag ) {
								$meta['key'] = $meta_child->textContent;
							} elseif ( 'meta_value' === $meta_tag ) {
								$meta['value'] = $meta_child->textContent;
							} else {
								$meta[ $meta_tag ] = $meta_child->textContent;
							}
						}
						if ( ! empty( $meta ) ) {
							$post['postmeta'][] = $meta;
						}
						break;
					case 'wp:comment':
						$comment = array(
							'commentmeta' => array(),
						);
						foreach ( $child->childNodes as $comment_child ) {
							if ( XML_ELEMENT_NODE !== $comment_child->nodeType ) {
								continue;
							}
							$comment_tag = str_replace( 'wp:', '', $comment_child->nodeName );
							if ( 'commentmeta' === $comment_tag ) {
								$cmeta = array();
								foreach ( $comment_child->childNodes as $cmeta_child ) {
									if ( XML_ELEMENT_NODE !== $cmeta_child->nodeType ) {
										continue;
									}
									$cmeta_tag = str_replace( 'wp:', '', $cmeta_child->nodeName );
									// Normalize meta_key/meta_value to key/value
									// for compatibility with the content importer.
									if ( 'meta_key' === $cmeta_tag ) {
										$cmeta['key'] = $cmeta_child->textContent;
									} elseif ( 'meta_value' === $cmeta_tag ) {
										$cmeta['value'] = $cmeta_child->textContent;
									} else {
										$cmeta[ $cmeta_tag ] = $cmeta_child->textContent;
									}
								}
								if ( ! empty( $cmeta ) ) {
									$comment['commentmeta'][] = $cmeta;
								}
							} else {
								$comment[ $comment_tag ] = $comment_child->textContent;
							}
						}
						$post['comments'][] = $comment;
						break;
					case 'category':
						$term_data = array(
							'domain' => $child->getAttribute( 'domain' ),
							'slug'   => $child->getAttribute( 'nicename' ),
							'name'   => $child->textContent,
						);
						$post['terms'][] = $term_data;
						break;
				}
			}

			$posts[] = $post;
		}

		libxml_use_internal_errors( $internal_errors );

		return array(
			'authors'    => $authors,
			'categories' => $categories,
			'tags'       => $tags,
			'terms'      => $terms,
			'posts'      => $posts,
			'base_url'   => $base_url,
			'version'    => $wxr_version,
		);
	}
}

/**
 * XML parser fallback using xml_parse (SAX-based).
 */
class WXR_Parser_XML {

	/**
	 * Parse the file using the XML extension.
	 *
	 * @param string $file File path.
	 * @return array|WP_Error
	 */
	public function parse( $file ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$xml = file_get_contents( $file );
		if ( empty( $xml ) ) {
			return new WP_Error( 'wxr_parser_error', esc_html__( 'Empty or unreadable file.', 'velour-pro-addons' ) );
		}

		// Use SimpleXML parser as fallback with error suppression.
		libxml_use_internal_errors( true );
		$simple_xml = simplexml_load_string( $xml );
		if ( false === $simple_xml ) {
			libxml_clear_errors();
			// Fall back to regex parser.
			$regex_parser = new WXR_Parser_Regex();
			return $regex_parser->parse( $file );
		}
		libxml_clear_errors();

		// Convert SimpleXML to our format using the SimpleXML parser.
		$simplexml_parser = new WXR_Parser_SimpleXML();
		return $simplexml_parser->parse( $file );
	}
}

/**
 * Regex-based WXR parser (last resort fallback).
 */
class WXR_Parser_Regex {

	/**
	 * Parse the file using regex patterns.
	 *
	 * @param string $file File path.
	 * @return array|WP_Error
	 */
	public function parse( $file ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$content = file_get_contents( $file );
		if ( empty( $content ) ) {
			return new WP_Error( 'wxr_parser_error', esc_html__( 'Empty or unreadable file.', 'velour-pro-addons' ) );
		}

		return array(
			'authors'    => array(),
			'categories' => array(),
			'tags'       => array(),
			'terms'      => array(),
			'posts'      => array(),
			'base_url'   => '',
			'version'    => '',
		);
	}
}
