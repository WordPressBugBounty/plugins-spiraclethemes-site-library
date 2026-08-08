<?php
/**
 * Spiraclethemes Site Library - Content Importer
 *
 * Imports WordPress content from a WXR (XML) export file.
 * Handles attachment downloads, post meta ID remapping, and term meta.
 *
 * @package spiraclethemes-site-library
 * @subpackage inc/demo-importer
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spiracle_Content_Importer {

	const MAX_IMPORT_AUTHORS = 50;

	/**
	 * Private/internal IP address patterns blocked during attachment downloads.
	 *
	 * Mirrors the protection in Spiracle_Demo_Import::download_file() to prevent
	 * SSRF attacks via malicious attachment URLs in imported WXR files.
	 *
	 * @var array
	 */
	const PRIVATE_IP_PATTERNS = [
		'/^10\./',
		'/^172\.(1[6-9]|2[0-9]|3[01])\./',
		'/^192\.168\./',
		'/^127\./',
		'/^0\./',
		'/^169\.254\./',
		'/^::1$/',
		'/^fc/',
		'/^fd/',
		'/^fe80:/',
	];

	/**
	 * Mapping from old post IDs to new post IDs.
	 *
	 * @var array
	 */
	private $post_id_map = array();

	/**
	 * Mapping from old term IDs to new term IDs.
	 *
	 * @var array
	 */
	private $term_id_map = array();

	/**
	 * Mapping from old attachment URLs to new local URLs.
	 *
	 * @var array
	 */
	private $url_map = array();

	/**
	 * Get the old-to-new post ID mapping after import.
	 *
	 * @return array Associative array of old_post_id => new_post_id.
	 */
	public function get_post_id_map() {
		return $this->post_id_map;
	}

	/**
	 * Get the old-to-new term ID mapping after import.
	 *
	 * @return array Associative array of old_term_id => new_term_id.
	 */
	public function get_term_id_map() {
		return $this->term_id_map;
	}

	/**
	 * Import content from an XML file.
	 *
	 * @param string $file Absolute path to the XML file.
	 * @return true|WP_Error True on success, WP_Error on failure.
	 */
	public function import( $file ) {
		if ( ! file_exists( $file ) ) {
			return new WP_Error( 'spiracle_content_missing', esc_html__( 'Content XML file does not exist.', 'spiraclethemes-site-library' ) );
		}

		if ( ! is_readable( $file ) ) {
			return new WP_Error( 'spiracle_content_unreadable', esc_html__( 'Content XML file is not readable.', 'spiraclethemes-site-library' ) );
		}

		// Try using the WordPress Importer plugin if available.
		if ( class_exists( 'WP_Import' ) ) {
			return $this->import_with_wp_importer( $file );
		}

		// Fall back to our own WXR parser.
		return $this->import_with_native_parser( $file );
	}

	/**
	 * Import using the WordPress Importer plugin's WP_Import class.
	 *
	 * @param string $file Absolute path to the XML file.
	 * @return true|WP_Error
	 */
	private function import_with_wp_importer( $file ) {
		$wxr_terms = $this->extract_wxr_term_ids( $file );

		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$importer = new WP_Import();
		$importer->fetch_attachments = true;

		ob_start();
		$importer->import( $file );
		ob_end_clean();

		if ( ! empty( $wxr_terms ) ) {
			foreach ( $wxr_terms as $old_id => $info ) {
				if ( isset( $this->term_id_map[ $old_id ] ) ) {
					continue;
				}
				$term_obj = get_term_by( 'slug', $info['slug'], $info['taxonomy'] );
				if ( $term_obj && $term_obj->term_id !== $old_id ) {
					$this->term_id_map[ $old_id ] = $term_obj->term_id;
				}
			}
		}

		return true;
	}

	/**
	 * Extract old term IDs with their slugs and taxonomies from a WXR file.
	 *
	 * Used by import_with_wp_importer() to build a term ID map after
	 * the WordPress Importer plugin creates terms with new IDs.
	 *
	 * @param string $file Absolute path to the WXR file.
	 * @return array Associative array of old_term_id => array( 'slug' => ..., 'taxonomy' => ... ).
	 */
	private function extract_wxr_term_ids( $file ) {
		if ( ! class_exists( 'Spir_WXR_Parser' ) ) {
			$this->load_wxr_parser();
		}

		$parser = new Spir_WXR_Parser();
		$data   = $parser->parse( $file );

		if ( is_wp_error( $data ) || empty( $data['terms'] ) ) {
			return array();
		}

		$result = array();
		foreach ( $data['terms'] as $term ) {
			$old_id   = isset( $term['term_id'] ) ? absint( $term['term_id'] ) : 0;
			$slug     = isset( $term['term_slug'] ) ? $term['term_slug'] : '';
			$taxonomy = isset( $term['term_taxonomy'] ) ? $term['term_taxonomy'] : '';

			if ( $old_id && $slug && $taxonomy ) {
				$result[ $old_id ] = array(
					'slug'     => $slug,
					'taxonomy' => $taxonomy,
				);
			}
		}

		return $result;
	}

	/**
	 * Import using the built-in native WXR parser.
	 *
	 * @param string $file Absolute path to the XML file.
	 * @return true|WP_Error
	 */
	private function import_with_native_parser( $file ) {
		ob_start();

		if ( ! function_exists( 'get_importers' ) ) {
			require_once ABSPATH . 'wp-admin/includes/import.php';
		}

		if ( ! function_exists( 'media_sideload_image' ) ) {
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}
		if ( ! function_exists( 'wp_read_image_metadata' ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
		}
		if ( ! function_exists( 'download_url' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( ! class_exists( 'Spir_WXR_Parser' ) ) {
			$this->load_wxr_parser();
		}

		$parser = new Spir_WXR_Parser();
		$data   = $parser->parse( $file );

		if ( is_wp_error( $data ) ) {
			ob_end_clean();
			return $data;
		}

		if ( ! empty( $data['authors'] ) ) {
			$this->import_authors( $data['authors'] );
		}

		if ( ! empty( $data['categories'] ) ) {
			$this->import_categories( $data['categories'] );
		}

		if ( ! empty( $data['tags'] ) ) {
			$this->import_tags( $data['tags'] );
		}

		if ( ! empty( $data['terms'] ) ) {
			$this->import_terms( $data['terms'] );
		}

		if ( ! empty( $data['posts'] ) ) {
			$this->import_posts( $data['posts'] );
		}

		ob_end_clean();

		return true;
	}

	/**
	 * Load the WXR parser class.
	 */
	private function load_wxr_parser() {
		// Always load the bundled parser which defines Spir_WXR_Parser.
		$bundled_parser = dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';
		if ( file_exists( $bundled_parser ) ) {
			require_once $bundled_parser;
		}
	}

	/**
	 * Import authors from WXR data.
	 *
	 * @param array $authors Array of author data.
	 */
	private function import_authors( $authors ) {
		$created = 0;

		foreach ( $authors as $author ) {
			if ( $created >= self::MAX_IMPORT_AUTHORS ) {
				break;
			}

			$login = isset( $author['author_login'] ) ? $author['author_login'] : '';
			if ( empty( $login ) ) {
				continue;
			}

			if ( ! validate_username( $login ) ) {
				continue;
			}

			$user = get_user_by( 'login', $login );
			if ( $user ) {
				continue;
			}

			$email = isset( $author['author_email'] ) ? $author['author_email'] : '';
			if ( ! empty( $email ) && ! is_email( $email ) ) {
				$email = '';
			}
			if ( empty( $email ) ) {
				$email = $login . '@example.com';
			}

			$user_data = array(
				'user_login'    => $login,
				'user_pass'     => wp_generate_password(),
				'user_email'    => $email,
				'display_name'  => isset( $author['author_display_name'] ) ? $author['author_display_name'] : $login,
				'first_name'    => isset( $author['author_first_name'] ) ? $author['author_first_name'] : '',
				'last_name'     => isset( $author['author_last_name'] ) ? $author['author_last_name'] : '',
				'role'          => 'subscriber',
			);

			$result = wp_insert_user( $user_data );
			if ( ! is_wp_error( $result ) ) {
				$created++;
			}
		}
	}

	/**
	 * Import categories from WXR data.
	 *
	 * @param array $categories Array of category data.
	 */
	private function import_categories( $categories ) {
		foreach ( $categories as $cat ) {
			$cat_name = isset( $cat['cat_name'] ) ? $cat['cat_name'] : '';
			if ( empty( $cat_name ) ) {
				continue;
			}

			$category_nicename    = isset( $cat['category_nicename'] ) ? $cat['category_nicename'] : sanitize_title( $cat_name );
			$category_parent      = isset( $cat['category_parent'] ) ? $cat['category_parent'] : '';
			$category_description = isset( $cat['cat_desc'] ) ? $cat['cat_desc'] : '';

			$parent_id = 0;
			if ( ! empty( $category_parent ) ) {
				$parent_term = get_term_by( 'slug', $category_parent, 'category' );
				if ( $parent_term ) {
					$parent_id = $parent_term->term_id;
				}
			}

			$existing = get_term_by( 'slug', $category_nicename, 'category' );
			if ( $existing ) {
				continue;
			}

			wp_insert_category( array(
				'cat_name'             => $cat_name,
				'category_nicename'    => $category_nicename,
				'category_parent'      => $parent_id,
				'category_description' => $category_description,
			) );
		}
	}

	/**
	 * Import tags from WXR data.
	 *
	 * @param array $tags Array of tag data.
	 */
	private function import_tags( $tags ) {
		foreach ( $tags as $tag ) {
			$tag_name = isset( $tag['tag_name'] ) ? $tag['tag_name'] : '';
			if ( empty( $tag_name ) ) {
				continue;
			}

			$tag_slug = isset( $tag['tag_slug'] ) ? $tag['tag_slug'] : sanitize_title( $tag_name );

			$existing = get_term_by( 'slug', $tag_slug, 'post_tag' );
			if ( $existing ) {
				continue;
			}

			wp_insert_term( $tag_name, 'post_tag', array(
				'slug' => $tag_slug,
			) );
		}
	}

	/**
	 * Import custom terms from WXR data.
	 *
	 * @param array $terms Array of term data.
	 */
	private function import_terms( $terms ) {
		foreach ( $terms as $term ) {
			$term_name = isset( $term['term_name'] ) ? $term['term_name'] : '';
			$taxonomy  = isset( $term['term_taxonomy'] ) ? $term['term_taxonomy'] : '';

			if ( empty( $term_name ) || empty( $taxonomy ) ) {
				continue;
			}

			if ( ! taxonomy_exists( $taxonomy ) ) {
				continue;
			}

		$term_slug = isset( $term['term_slug'] ) ? $term['term_slug'] : sanitize_title( $term_name );

		$existing = get_term_by( 'slug', $term_slug, $taxonomy );
		if ( $existing ) {
			$old_term_id = isset( $term['term_id'] ) ? absint( $term['term_id'] ) : 0;
				if ( $old_term_id && $old_term_id !== $existing->term_id ) {
					$this->term_id_map[ $old_term_id ] = $existing->term_id;
				}
				$this->import_term_meta( $existing->term_id, $term );
				continue;
			}

			$args = array( 'slug' => $term_slug );

			if ( ! empty( $term['term_parent'] ) ) {
				$parent_term = get_term_by( 'slug', $term['term_parent'], $taxonomy );
				if ( $parent_term ) {
					$args['parent'] = $parent_term->term_id;
				}
			}

			if ( ! empty( $term['term_description'] ) ) {
				$args['description'] = $term['term_description'];
			}

			$result = wp_insert_term( $term_name, $taxonomy, $args );

			if ( is_wp_error( $result ) ) {
				continue;
			}

			$new_term_id = (int) $result['term_id'];

			$old_term_id = isset( $term['term_id'] ) ? absint( $term['term_id'] ) : 0;
			if ( $old_term_id && $old_term_id !== $new_term_id ) {
				$this->term_id_map[ $old_term_id ] = $new_term_id;
			}

			$this->import_term_meta( $new_term_id, $term );
		}
	}

	/**
	 * Safely unserialize a value, rejecting any PHP objects.
	 *
	 * @param mixed $value The value to maybe unserialize.
	 * @return mixed The unserialized value (arrays/scalars only) or the original value.
	 */
	private function safe_maybe_unserialize( $value ) {
		if ( ! is_string( $value ) ) {
			return $value;
		}

		if ( ! preg_match( '/^[aOs]:/', $value ) ) {
			return $value;
		}

		if ( false !== strpos( $value, 'O:' ) && preg_match( '/\bO:\d+:/', $value ) ) {
			return $value;
		}

		$unserialized = @unserialize( $value, array( 'allowed_classes' => false ) );

		if ( false === $unserialized && $value !== serialize( false ) ) {
			return $value;
		}

		return $unserialized;
	}

	/**
	 * Import term meta for a term.
	 *
	 * @param int   $term_id The new term ID.
	 * @param array $term    The term data array from the WXR parser.
	 */
	private function import_term_meta( $term_id, $term ) {
		if ( empty( $term['term_meta'] ) || ! is_array( $term['term_meta'] ) ) {
			return;
		}

		foreach ( $term['term_meta'] as $meta ) {
			$meta_key   = isset( $meta['key'] ) ? $meta['key'] : '';
			$meta_value = isset( $meta['value'] ) ? $meta['value'] : '';

			if ( empty( $meta_key ) ) {
				continue;
			}

			if ( 0 === strpos( $meta_key, 'product_count_' ) ) {
				continue;
			}

			$existing_meta = get_term_meta( $term_id, $meta_key, true );
			if ( $existing_meta ) {
				continue;
			}

			add_term_meta( $term_id, wp_slash( $meta_key ), wp_slash( $meta_value ) );
		}
	}

	/**
	 * Import posts from WXR data.
	 *
	 * @param array $posts Array of post data.
	 */
	private function import_posts( $posts ) {
		global $wpdb;

		$attachments = array();
		$nav_items   = array();
		$other_posts = array();

		foreach ( $posts as $post ) {
			$post_type = isset( $post['post_type'] ) ? $post['post_type'] : 'post';
			if ( 'attachment' === $post_type ) {
				$attachments[] = $post;
			} elseif ( 'nav_menu_item' === $post_type ) {
				$nav_items[] = $post;
			} else {
				$other_posts[] = $post;
			}
		}

		// First pass: import attachments.
		foreach ( $attachments as $attachment ) {
			$this->import_attachment( $attachment );
		}

		// Second pass: import all other posts.
		foreach ( $other_posts as $post ) {
			$post_title = isset( $post['post_title'] ) ? $post['post_title'] : '';
			$post_type  = isset( $post['post_type'] ) ? $post['post_type'] : 'post';

			if ( empty( $post_title ) && empty( $post['post_content'] ) ) {
				continue;
			}

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$existing = $wpdb->get_var( $wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = %s LIMIT 1",
				$post_title,
				$post_type
			) );

			if ( $existing ) {
				$this->import_post_meta( $existing, $post );
				if ( ! empty( $post['post_id'] ) ) {
					$this->post_id_map[ absint( $post['post_id'] ) ] = (int) $existing;
				}
				continue;
			}

			$post_author = isset( $post['post_author'] ) ? $post['post_author'] : '';
			$author_id   = get_current_user_id();
			if ( ! empty( $post_author ) ) {
				$user = get_user_by( 'login', $post_author );
				if ( $user ) {
					$author_id = $user->ID;
				}
			}

			$post_data = array(
				'post_title'     => $post_title,
				'post_content'   => isset( $post['post_content'] ) ? $post['post_content'] : '',
				'post_excerpt'   => isset( $post['post_excerpt'] ) ? $post['post_excerpt'] : '',
				'post_status'    => isset( $post['status'] ) ? $post['status'] : 'publish',
				'post_type'      => $post_type,
				'post_author'    => $author_id,
				'post_date'      => isset( $post['post_date'] ) ? $post['post_date'] : current_time( 'mysql' ),
				'post_date_gmt'  => isset( $post['post_date_gmt'] ) ? $post['post_date_gmt'] : current_time( 'mysql', true ),
				'post_name'      => isset( $post['post_name'] ) ? $post['post_name'] : sanitize_title( $post_title ),
				'comment_status' => isset( $post['comment_status'] ) ? $post['comment_status'] : 'closed',
				'ping_status'    => isset( $post['ping_status'] ) ? $post['ping_status'] : 'closed',
				'menu_order'     => isset( $post['menu_order'] ) ? absint( $post['menu_order'] ) : 0,
			);

			if ( ! empty( $post['post_parent'] ) ) {
				$old_parent             = absint( $post['post_parent'] );
				$post_data['post_parent'] = isset( $this->post_id_map[ $old_parent ] )
					? $this->post_id_map[ $old_parent ]
					: $old_parent;
			}

			$post_id = wp_insert_post( wp_slash( $post_data ), true );

			if ( is_wp_error( $post_id ) ) {
				continue;
			}

			if ( ! empty( $post['post_id'] ) ) {
				$this->post_id_map[ absint( $post['post_id'] ) ] = $post_id;
			}

			$this->import_post_meta( $post_id, $post );
			$this->import_post_terms( $post_id, $post );

			if ( ! empty( $post['comments'] ) ) {
				$this->import_comments( $post_id, $post['comments'] );
			}
		}

		// Third pass: import nav_menu_item posts.
		foreach ( $nav_items as $post ) {
			$this->import_nav_menu_item( $post );
		}

		// Remap term meta that references old attachment IDs.
		$this->remap_term_meta();
	}

	/**
	 * Import a single nav_menu_item post.
	 *
	 * @param array $post Nav menu item post data.
	 */
	private function import_nav_menu_item( $post ) {
		$old_post_id = isset( $post['post_id'] ) ? absint( $post['post_id'] ) : 0;

		if ( $old_post_id && isset( $this->post_id_map[ $old_post_id ] ) ) {
			return;
		}

		$post_author = isset( $post['post_author'] ) ? $post['post_author'] : '';
		$author_id   = get_current_user_id();
		if ( ! empty( $post_author ) ) {
			$user = get_user_by( 'login', $post_author );
			if ( $user ) {
				$author_id = $user->ID;
			}
		}

		$post_data = array(
			'post_title'     => isset( $post['post_title'] ) ? $post['post_title'] : '',
			'post_content'   => isset( $post['post_content'] ) ? $post['post_content'] : '',
			'post_excerpt'   => isset( $post['post_excerpt'] ) ? $post['post_excerpt'] : '',
			'post_status'    => isset( $post['status'] ) ? $post['status'] : 'publish',
			'post_type'      => 'nav_menu_item',
			'post_author'    => $author_id,
			'post_date'      => isset( $post['post_date'] ) ? $post['post_date'] : current_time( 'mysql' ),
			'post_date_gmt'  => isset( $post['post_date_gmt'] ) ? $post['post_date_gmt'] : current_time( 'mysql', true ),
			'post_name'      => isset( $post['post_name'] ) ? $post['post_name'] : '',
			'comment_status' => isset( $post['comment_status'] ) ? $post['comment_status'] : 'closed',
			'ping_status'    => isset( $post['ping_status'] ) ? $post['ping_status'] : 'closed',
			'menu_order'     => isset( $post['menu_order'] ) ? absint( $post['menu_order'] ) : 0,
		);

		$post_id = wp_insert_post( wp_slash( $post_data ), true );

		if ( is_wp_error( $post_id ) ) {
			return;
		}

		if ( $old_post_id ) {
			$this->post_id_map[ $old_post_id ] = $post_id;
		}

		$this->import_post_meta( $post_id, $post );
		$this->import_post_terms( $post_id, $post );
	}

	/**
	 * Determine whether a host name refers to the local machine.
	 *
	 * Used by is_safe_remote_url() to allow local-dev attachment URLs
	 * (e.g. site.local) while blocking external hosts that resolve to
	 * private IPs.
	 *
	 * @param string $host Host name (no scheme, no port).
	 * @return bool
	 */
	private function is_local_host( $host ) {
		$local_patterns = [
			'/\.local$/',
			'/\.test$/',
			'/\.dev$/',
			'/\.localhost$/',
			'/\.internal$/',
			'/^localhost$/',
			'/^127\./',
			'/^10\./',
			'/^172\.(1[6-9]|2[0-9]|3[01])\./',
			'/^192\.168\./',
		];

		foreach ( $local_patterns as $pattern ) {
			if ( preg_match( $pattern, $host ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Validate a remote URL before downloading to prevent SSRF.
	 *
	 * Allows http/https URLs whose host either is a recognised local
	 * host (local-dev) or resolves to a public IP. Mirrors the guard in
	 * Spiracle_Demo_Import::download_file().
	 *
	 * @param string $url The attachment URL to validate.
	 * @return bool True if the URL is safe to fetch, false otherwise.
	 */
	private function is_safe_remote_url( $url ) {
		$scheme = wp_parse_url( $url, PHP_URL_SCHEME );
		if ( ! in_array( $scheme, [ 'http', 'https' ], true ) ) {
			return false;
		}

		$host = wp_parse_url( $url, PHP_URL_HOST );
		if ( ! $host ) {
			return false;
		}

		// Local-dev hosts bypass the private-IP check, matching download_file().
		if ( $this->is_local_host( $host ) ) {
			return true;
		}

		$ip = gethostbyname( $host );
		if ( $ip === $host ) {
			// DNS resolution failed.
			return false;
		}

		foreach ( self::PRIVATE_IP_PATTERNS as $pattern ) {
			if ( preg_match( $pattern, $ip ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Import a single attachment post.
	 *
	 * @param array $post Attachment post data.
	 */
	private function import_attachment( $post ) {
		global $wpdb;

		$post_title     = isset( $post['post_title'] ) ? $post['post_title'] : '';
		$attachment_url = isset( $post['attachment_url'] ) ? $post['attachment_url'] : '';

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$existing = $wpdb->get_var( $wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = 'attachment' LIMIT 1",
			$post_title
		) );

		if ( $existing ) {
			if ( ! empty( $post['post_id'] ) ) {
				$this->post_id_map[ absint( $post['post_id'] ) ] = (int) $existing;
			}
			if ( ! empty( $attachment_url ) ) {
				$new_url = wp_get_attachment_url( (int) $existing );
				if ( $new_url ) {
					$this->url_map[ $attachment_url ] = $new_url;
				}
			}
			return;
		}

		if ( empty( $attachment_url ) ) {
			return;
		}

		// SSRF guard: reject attachment URLs pointing to private/internal hosts.
		if ( ! $this->is_safe_remote_url( $attachment_url ) ) {
			return;
		}

		$post_author = isset( $post['post_author'] ) ? $post['post_author'] : '';
		$author_id   = get_current_user_id();
		if ( ! empty( $post_author ) ) {
			$user = get_user_by( 'login', $post_author );
			if ( $user ) {
				$author_id = $user->ID;
			}
		}

		$attach_id = media_sideload_image( $attachment_url, 0, $post_title, 'id' );

		if ( is_wp_error( $attach_id ) ) {
			$attach_data = array(
				'post_title'     => $post_title,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_author'    => $author_id,
				'post_mime_type' => $this->guess_mime_type( $attachment_url ),
				'guid'           => esc_url_raw( $attachment_url ),
			);

			$attach_id = wp_insert_attachment( wp_slash( $attach_data ), false, 0, true );

			if ( is_wp_error( $attach_id ) ) {
				return;
			}
		}

		if ( ! empty( $post['post_id'] ) ) {
			$this->post_id_map[ absint( $post['post_id'] ) ] = (int) $attach_id;
		}

		if ( ! empty( $attachment_url ) ) {
			$new_url = wp_get_attachment_url( (int) $attach_id );
			if ( $new_url ) {
				$this->url_map[ $attachment_url ] = $new_url;
			}
		}

		$this->import_post_meta( $attach_id, $post );
	}

	/**
	 * Guess MIME type from a file URL.
	 *
	 * @param string $url The file URL.
	 * @return string The guessed MIME type.
	 */
	private function guess_mime_type( $url ) {
		$ext  = strtolower( pathinfo( wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION ) );
		$types = array(
			'jpg'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png'  => 'image/png',
			'gif'  => 'image/gif',
			'webp' => 'image/webp',
			'svg'  => 'image/svg+xml',
			'pdf'  => 'application/pdf',
			'mp4'  => 'video/mp4',
			'webm' => 'video/webm',
		);
		return isset( $types[ $ext ] ) ? $types[ $ext ] : 'image/jpeg';
	}

	/**
	 * Import post meta data with ID remapping.
	 *
	 * @param int   $post_id The post ID.
	 * @param array $post    The post data array.
	 */
	private function import_post_meta( $post_id, $post ) {
		if ( empty( $post['postmeta'] ) || ! is_array( $post['postmeta'] ) ) {
			return;
		}

		$menu_type = '';

		foreach ( $post['postmeta'] as $meta ) {
			$key   = isset( $meta['key'] ) ? $meta['key'] : '';
			$value = isset( $meta['value'] ) ? $meta['value'] : '';

			if ( empty( $key ) ) {
				continue;
			}

			if ( '_' === substr( $key, 0, 1 ) && in_array( $key, array( '_edit_lock', '_edit_last' ), true ) ) {
				continue;
			}

			if ( '_elementor_element_cache' === $key ) {
				continue;
			}

			if ( '_thumbnail_id' === $key ) {
				$old_thumb_id = absint( $value );
				if ( isset( $this->post_id_map[ $old_thumb_id ] ) ) {
					$value = $this->post_id_map[ $old_thumb_id ];
				} else {
					continue;
				}
			}

			if ( '_product_image_gallery' === $key ) {
				$value = $this->remap_gallery_ids( $value );
			}

			if ( '_elementor_data' === $key && ( ! empty( $this->post_id_map ) || ! empty( $this->url_map ) ) ) {
				$value = $this->remap_elementor_ids( $value );
			}

			if ( '_wp_attachment_metadata' === $key || '_wp_attached_file' === $key ) {
				continue;
			}

			if ( '_menu_item_type' === $key ) {
				$menu_type = $value;
			}

			if ( '_menu_item_object_id' === $key ) {
				$old_object_id = absint( $value );
				if ( 'taxonomy' === $menu_type ) {
					if ( isset( $this->term_id_map[ $old_object_id ] ) ) {
						$value = $this->term_id_map[ $old_object_id ];
					}
				} else {
					if ( isset( $this->post_id_map[ $old_object_id ] ) ) {
						$value = $this->post_id_map[ $old_object_id ];
					}
				}
			}

			if ( '_menu_item_menu_item_parent' === $key ) {
				$old_parent_id = absint( $value );
				if ( $old_parent_id > 0 && isset( $this->post_id_map[ $old_parent_id ] ) ) {
					$value = $this->post_id_map[ $old_parent_id ];
				}
			}

			$existing = get_post_meta( $post_id, $key, true );
			if ( $existing && $existing === $value ) {
				continue;
			}

			update_post_meta( $post_id, wp_slash( $key ), wp_slash( $this->safe_maybe_unserialize( $value ) ) );
		}
	}

	/**
	 * Remap comma-separated attachment IDs in _product_image_gallery.
	 *
	 * @param string $gallery Comma-separated old attachment IDs.
	 * @return string Comma-separated new attachment IDs.
	 */
	private function remap_gallery_ids( $gallery ) {
		if ( empty( $gallery ) ) {
			return $gallery;
		}

		$ids     = explode( ',', $gallery );
		$new_ids = array();

		foreach ( $ids as $id ) {
			$old_id = absint( trim( $id ) );
			if ( isset( $this->post_id_map[ $old_id ] ) ) {
				$new_ids[] = $this->post_id_map[ $old_id ];
			}
		}

		return implode( ',', $new_ids );
	}

	/**
	 * Remap old attachment IDs inside Elementor JSON data.
	 *
	 * @param string $json The raw _elementor_data JSON string.
	 * @return string The JSON string with remapped IDs.
	 */
	private function remap_elementor_ids( $json ) {
		if ( empty( $json ) ) {
			return $json;
		}

		if ( ! empty( $this->post_id_map ) ) {
			$sorted_map = $this->post_id_map;
			uksort( $sorted_map, function ( $a, $b ) {
				return strlen( (string) $b ) - strlen( (string) $a );
			});

			foreach ( $sorted_map as $old_id => $new_id ) {
				if ( $old_id === $new_id ) {
					continue;
				}

				$old_str = (string) $old_id;
				$new_str = (string) $new_id;

				// Replace unquoted numeric IDs in "id" fields (attachment IDs in image/media objects).
				$json = preg_replace(
					'/"id"\s*:\s*' . preg_quote( $old_str, '/' ) . '\b/',
					'"id":' . $new_str,
					$json
				);

				// Replace IDs in specific Elementor fields that store post/attachment IDs
				// as quoted strings. Only target known field names to avoid corrupting
				// widget settings like prod_count, prod_columns_count, etc.
				$id_field_names = array(
					'post_id',
					'attachment_id',
					'template_id',
					'fallback_id',
					'nav_menu',
					'form_id',
					'source',
				);

				foreach ( $id_field_names as $field ) {
					// Quoted value: "field":"old_id"
					$json = preg_replace(
						'/"' . preg_quote( $field, '/' ) . '"\s*:\s*"' . preg_quote( $old_str, '/' ) . '"/',
						'"' . $field . '":"' . $new_str . '"',
						$json
					);
					// Unquoted value: "field":old_id
					$json = preg_replace(
						'/"' . preg_quote( $field, '/' ) . '"\s*:\s*' . preg_quote( $old_str, '/' ) . '\b/',
						'"' . $field . '":' . $new_str,
						$json
					);
				}
			}
		}

		if ( ! empty( $this->url_map ) ) {
			foreach ( $this->url_map as $old_url => $new_url ) {
				$old_url_json = str_replace( '/', '\\/', $old_url );
				$new_url_json = str_replace( '/', '\\/', $new_url );
				$json = str_replace( $old_url_json, $new_url_json, $json );
			}
		}

		return $json;
	}

	/**
	 * Remap term meta that references old attachment IDs.
	 */
	private function remap_term_meta() {
		global $wpdb;

		if ( empty( $this->post_id_map ) ) {
			return;
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$term_metas = $wpdb->get_results(
			"SELECT meta_id, term_id, meta_value FROM {$wpdb->termmeta} WHERE meta_key = 'thumbnail_id'"
		);

		foreach ( $term_metas as $tm ) {
			$old_id = absint( $tm->meta_value );
			if ( isset( $this->post_id_map[ $old_id ] ) ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$wpdb->update(
					$wpdb->termmeta,
					array( 'meta_value' => $this->post_id_map[ $old_id ] ),
					array( 'meta_id' => $tm->meta_id ),
					array( '%d' ),
					array( '%d' )
				);
			}
		}
	}

	/**
	 * Import terms for a post.
	 *
	 * @param int   $post_id The post ID.
	 * @param array $post    The post data array.
	 */
	private function import_post_terms( $post_id, $post ) {
		if ( empty( $post['terms'] ) || ! is_array( $post['terms'] ) ) {
			return;
		}

		$terms = array();
		foreach ( $post['terms'] as $term_data ) {
			$taxonomy = isset( $term_data['domain'] ) ? $term_data['domain'] : '';
			$slug     = isset( $term_data['slug'] ) ? $term_data['slug'] : '';
			$name     = isset( $term_data['name'] ) ? $term_data['name'] : '';

			if ( empty( $taxonomy ) || empty( $slug ) ) {
				continue;
			}

			if ( ! taxonomy_exists( $taxonomy ) ) {
				continue;
			}

			$term = get_term_by( 'slug', $slug, $taxonomy );
			if ( ! $term ) {
				$result = wp_insert_term( $name, $taxonomy, array( 'slug' => $slug ) );
				if ( is_wp_error( $result ) ) {
					continue;
				}
				$term_id = $result['term_id'];
			} else {
				$term_id = $term->term_id;
			}

			if ( ! isset( $terms[ $taxonomy ] ) ) {
				$terms[ $taxonomy ] = array();
			}
			$terms[ $taxonomy ][] = (int) $term_id;
		}

		foreach ( $terms as $taxonomy => $term_ids ) {
			wp_set_post_terms( $post_id, $term_ids, $taxonomy );
		}
	}

	/**
	 * Import comments for a post.
	 *
	 * @param int   $post_id  The post ID.
	 * @param array $comments Array of comment data.
	 */
	private function import_comments( $post_id, $comments ) {
		foreach ( $comments as $comment ) {
			$comment_data = array(
				'comment_post_ID'      => $post_id,
				'comment_author'       => isset( $comment['comment_author'] ) ? $comment['comment_author'] : '',
				'comment_author_email' => isset( $comment['comment_author_email'] ) ? $comment['comment_author_email'] : '',
				'comment_author_url'   => isset( $comment['comment_author_url'] ) ? $comment['comment_author_url'] : '',
				'comment_content'      => isset( $comment['comment_content'] ) ? $comment['comment_content'] : '',
				'comment_date'         => isset( $comment['comment_date'] ) ? $comment['comment_date'] : current_time( 'mysql' ),
				'comment_approved'     => isset( $comment['comment_approved'] ) ? $comment['comment_approved'] : 1,
				'comment_type'         => isset( $comment['comment_type'] ) ? $comment['comment_type'] : '',
			);

			$duplicate = get_comments( array(
				'post_id'      => $post_id,
				'author_email' => $comment_data['comment_author_email'],
				'date_query'   => array(
					array(
						'year'  => gmdate( 'Y', strtotime( $comment_data['comment_date'] ) ),
						'month' => gmdate( 'm', strtotime( $comment_data['comment_date'] ) ),
						'day'   => gmdate( 'd', strtotime( $comment_data['comment_date'] ) ),
					),
				),
			) );

			if ( ! empty( $duplicate ) ) {
				continue;
			}

			$comment_id = wp_insert_comment( $comment_data );

			if ( $comment_id && ! empty( $comment['commentmeta'] ) ) {
				foreach ( $comment['commentmeta'] as $meta ) {
					if ( ! empty( $meta['key'] ) ) {
						add_comment_meta( $comment_id, wp_slash( $meta['key'] ), wp_slash( $this->safe_maybe_unserialize( $meta['value'] ) ) );
					}
				}
			}
		}
	}
}
