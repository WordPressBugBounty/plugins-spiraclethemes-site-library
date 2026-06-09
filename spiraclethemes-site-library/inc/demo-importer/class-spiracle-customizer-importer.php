<?php
/**
 * Spiraclethemes Site Library - Customizer Importer
 *
 * Imports customizer settings from a DAT file.
 * The DAT format is a serialized PHP array containing customizer mod data,
 * as exported by the OCDI (One Click Demo Import) plugin.
 *
 * @package spiraclethemes-site-library
 * @subpackage inc/demo-importer
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spiracle_Customizer_Importer {

	/**
	 * Mapping from old post IDs to new post IDs (for attachment remapping).
	 *
	 * @var array
	 */
	private $post_id_map = array();

	/**
	 * Theme mod keys that store attachment post IDs and need remapping.
	 *
	 * @var array
	 */
	private $attachment_mod_keys = array(
		'custom_logo',
		'background_image_id',
		'header_image_data',
	);

	/**
	 * Import customizer settings from a DAT file.
	 *
	 * @param string $file        Absolute path to the DAT file.
	 * @param array  $post_id_map Optional. Old-to-new post ID mapping for attachment remapping.
	 * @return true|WP_Error True on success, WP_Error on failure.
	 */
	public function import( $file, $post_id_map = array() ) {
		$this->post_id_map = is_array( $post_id_map ) ? $post_id_map : array();
		if ( ! file_exists( $file ) ) {
			return new WP_Error( 'spiracle_customizer_missing', esc_html__( 'Customizer DAT file does not exist.', 'spiraclethemes-site-library' ) );
		}

		if ( ! is_readable( $file ) ) {
			return new WP_Error( 'spiracle_customizer_unreadable', esc_html__( 'Customizer DAT file is not readable.', 'spiraclethemes-site-library' ) );
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$data = file_get_contents( $file );

		if ( empty( $data ) ) {
			return new WP_Error( 'spiracle_customizer_empty', esc_html__( 'Customizer DAT file is empty.', 'spiraclethemes-site-library' ) );
		}

		// Try JSON first (safe), then fall back to unserialize with strict validation.
		$customizer_data = json_decode( $data, true );

		if ( null === $customizer_data || JSON_ERROR_NONE !== json_last_error() ) {
			// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_unserialize -- Required for OCDI compatibility.
			// Only allow serialization of arrays/scalars — reject objects to prevent PHP Object Injection.
			$customizer_data = @unserialize( $data, array( 'allowed_classes' => false ) );
		}

		if ( false === $customizer_data ) {
			$customizer_data = json_decode( $data, true );
			if ( null === $customizer_data && JSON_ERROR_NONE !== json_last_error() ) {
				return new WP_Error( 'spiracle_customizer_invalid', esc_html__( 'Customizer DAT file contains invalid data.', 'spiraclethemes-site-library' ) );
			}
		}

		if ( ! is_array( $customizer_data ) ) {
			return new WP_Error( 'spiracle_customizer_format', esc_html__( 'Customizer data is not in the expected format.', 'spiraclethemes-site-library' ) );
		}

		// Handle OCDI-style export format.
		if ( isset( $customizer_data['mods'] ) ) {
			$this->import_mods( $customizer_data['mods'] );
		} elseif ( isset( $customizer_data['options'] ) ) {
			$this->import_options( $customizer_data['options'] );
		} else {
			$this->import_mods( $customizer_data );
		}

		if ( isset( $customizer_data['options'] ) && is_array( $customizer_data['options'] ) ) {
			$this->import_options( $customizer_data['options'] );
		}

		return true;
	}

	/**
	 * Import theme modification values.
	 *
	 * Remaps attachment post IDs in known theme mod keys using the
	 * old-to-new post ID mapping from the content import step.
	 *
	 * @param array $mods Associative array of theme_mod key => value pairs.
	 */
	private function import_mods( $mods ) {
		if ( ! is_array( $mods ) ) {
			return;
		}

		foreach ( $mods as $key => $value ) {
			if ( is_null( $value ) ) {
				remove_theme_mod( $key );
				continue;
			}

			if ( 'nav_menu_locations' === $key && is_array( $value ) ) {
				$this->import_nav_menu_locations( $value );
				continue;
			}

			// Remap attachment IDs for known theme mod keys.
			$value = $this->remap_attachment_ids( $key, $value );

			$sanitized_value = $this->sanitize_mod_value( $key, $value );
			set_theme_mod( $key, $sanitized_value );
		}
	}

	/**
	 * Remap old attachment post IDs to new ones in theme mod values.
	 *
	 * Handles both integer IDs (e.g. custom_logo) and serialized/object data
	 * containing attachment IDs (e.g. header_image_data).
	 *
	 * @param string $key   Theme mod key.
	 * @param mixed  $value The raw value.
	 * @return mixed Remapped value.
	 */
	private function remap_attachment_ids( $key, $value ) {
		if ( empty( $this->post_id_map ) ) {
			return $value;
		}

		// Direct attachment ID keys (stored as integers).
		if ( in_array( $key, $this->attachment_mod_keys, true ) ) {
			$old_id = 0;

			// Handle integer or numeric string values.
			if ( is_numeric( $value ) ) {
				$old_id = absint( $value );
			} elseif ( is_array( $value ) && isset( $value['attachment_id'] ) ) {
				// Handle array with attachment_id field (e.g. header_image_data).
				$old_id = absint( $value['attachment_id'] );
				if ( isset( $this->post_id_map[ $old_id ] ) ) {
					$value['attachment_id'] = $this->post_id_map[ $old_id ];
					// Also remap the URL if available.
					$new_url = wp_get_attachment_url( $value['attachment_id'] );
					if ( $new_url && isset( $value['url'] ) ) {
						$value['url'] = esc_url_raw( $new_url );
					}
				}
				return $value;
			}

			if ( $old_id && isset( $this->post_id_map[ $old_id ] ) ) {
				return $this->post_id_map[ $old_id ];
			}
		}

		// Handle theme-specific mod keys that may contain attachment IDs
		// (keys matching patterns like *_image_id, *_logo, *_logo_id, etc.).
		if ( is_numeric( $value ) && absint( $value ) > 0 ) {
			$id_suffixes = array( '_id', '_image_id', '_logo', '_logo_id', '_thumbnail_id' );
			foreach ( $id_suffixes as $suffix ) {
				if ( substr( $key, -strlen( $suffix ) ) === $suffix ) {
					$old_id = absint( $value );
					if ( isset( $this->post_id_map[ $old_id ] ) ) {
						return $this->post_id_map[ $old_id ];
					}
					break;
				}
			}
		}

		return $value;
	}

	/**
	 * Import WordPress options.
	 *
	 * Uses a whitelist of known-safe option prefixes/names to prevent
	 * arbitrary option injection. Theme-specific options are identified
	 * by matching the current theme slug prefix.
	 *
	 * @param array $options Associative array of option key => value pairs.
	 */
	private function import_options( $options ) {
		if ( ! is_array( $options ) ) {
			return;
		}

		$blacklisted_options = array(
			'siteurl',
			'home',
			'blogname',
			'blogdescription',
			'admin_email',
			'new_admin_email',
			'users_can_register',
			'default_role',
			'gmt_offset',
			'timezone_string',
			'date_format',
			'time_format',
			'start_of_week',
			'default_category',
			'default_email_category',
			'require_name_email',
			'comment_moderation',
			'comments_notify',
			'moderation_notify',
			'permalink_structure',
			'page_on_front',
			'page_for_posts',
			'show_on_front',
			'upload_path',
			'upload_url_path',
			'uploads_use_yearmonth_folders',
			'cron',
			'mailserver_login',
			'mailserver_pass',
			'mailserver_url',
			'mailserver_port',
			'ping_sites',
			'woocommerce_email_from_address',
			'woocommerce_email_from_name',
			'template',
			'stylesheet',
			'active_plugins',
			'blog_public',
			'wp_user_roles',
			'recently_edited',
			'disallowed_keys',
			'moderation_keys',
			'default_comment_status',
			'default_ping_status',
			'default_pingback_flag',
			'comment_max_links',
			'comment_whitelist',
			'comment_registration',
			'close_comments_for_old_posts',
			'close_comments_days_old',
			'thread_comments',
			'thread_comments_depth',
			'page_comments',
			'comments_per_page',
			'default_comments_page',
			'comment_order',
			'sticky_posts',
			'sidebars_widgets',
			'recovery_mode_cookie',
			'recovery_mode_expired',
			'auto_updater',
			'auto_core_update_notified',
			'adminhash',
			'auth_salt',
			'secure_auth_salt',
			'logged_in_salt',
			'nonce_salt',
			'secret',
			'db_version',
			'initial_db_version',
			'WPLANG',
			'can_compress_scripts',
			'html_type',
			'use_smilies',
			'use_trackback',
			'default_link_category',
			'image_default_link_type',
			'image_default_size',
			'image_default_align',
			'links_recently_updated_time',
			'links_recently_updated_append',
			'thumbnail_size_w',
			'thumbnail_size_h',
			'thumbnail_crop',
			'medium_size_w',
			'medium_size_h',
			'medium_large_size_w',
			'medium_large_size_h',
			'large_size_w',
			'large_size_h',
			'embed_autourls',
			'embed_size_w',
			'embed_size_h',
			'embed_oembed_discover',
			'uploads_use_yearmonth_folders',
		);

		$blacklisted_prefixes = array(
			'widget_',
			'sidebars_',
			'_transient_',
			'_site_transient_',
			'recovery_mode_',
			'wp_php',
			'wp_debug_',
			'auto_update_',
			'force_',
		);

		$theme_slug = get_option( 'stylesheet' );

		$allowed_prefixes = array(
			$theme_slug . '_',
			'theme_mods_',
			'woocommerce_',
			'yith_',
			'elementor_',
			'ekit_',
			'ohio_',
			'eael_',
			'woo_',
		);

		foreach ( $options as $key => $value ) {
			if ( in_array( $key, $blacklisted_options, true ) ) {
				continue;
			}

			$skip = false;
			foreach ( $blacklisted_prefixes as $prefix ) {
				if ( 0 === strpos( $key, $prefix ) ) {
					$skip = true;
					break;
				}
			}
			if ( $skip ) {
				continue;
			}

			$allowed = false;
			foreach ( $allowed_prefixes as $prefix ) {
				if ( 0 === strpos( $key, $prefix ) ) {
					$allowed = true;
					break;
				}
			}
			if ( ! $allowed ) {
				continue;
			}

			if ( is_null( $value ) ) {
				delete_option( $key );
				continue;
			}

			update_option( $key, $value );
		}
	}

	/**
	 * Import nav menu locations.
	 *
	 * @param array $locations Associative array of location => menu_id.
	 */
	private function import_nav_menu_locations( $locations ) {
		$existing_locations = get_theme_mod( 'nav_menu_locations', array() );
		$merged = array_merge( $existing_locations, $locations );
		set_theme_mod( 'nav_menu_locations', $merged );
	}

	/**
	 * Sanitize a theme mod value based on its key and type.
	 *
	 * @param string $key   Theme mod key.
	 * @param mixed  $value The raw value.
	 * @return mixed Sanitized value.
	 */
	private function sanitize_mod_value( $key, $value ) {
		if ( is_bool( $value ) ) {
			return $value;
		}

		if ( '' === $value ) {
			return '';
		}

		if ( is_numeric( $value ) && ! is_array( $value ) ) {
			if ( false !== strpos( (string) $value, '.' ) ) {
				return floatval( $value );
			}
			return intval( $value );
		}

		if ( is_array( $value ) ) {
			return $value;
		}

		if ( is_string( $value ) ) {
			if ( 0 === strpos( $value, 'http' ) || 0 === strpos( $value, '/' ) ) {
				return esc_url_raw( $value );
			}

			if ( preg_match( '/^#([a-fA-F0-9]{3}){1,2}$/', $value ) ) {
				return sanitize_hex_color( $value );
			}

			$html_keys = array( 'footer_credits', 'custom_css' );
			if ( in_array( $key, $html_keys, true ) ) {
				return wp_kses_post( $value );
			}

			return sanitize_text_field( $value );
		}

		return $value;
	}
}
