<?php
/**
 * Spiraclethemes Site Library - Widget Importer
 *
 * Imports widgets from a WIE (Widget Importer Exporter) JSON file.
 *
 * @package spiraclethemes-site-library
 * @subpackage inc/demo-importer
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spiracle_Widget_Importer {

	/**
	 * Import widgets from a WIE file.
	 *
	 * @param string $file        Absolute path to the WIE file.
	 * @param array  $term_id_map Optional. Old-to-new term ID mapping for remapping nav_menu widgets.
	 * @return true|WP_Error True on success, WP_Error on failure.
	 */
	public function import( $file, $term_id_map = array() ) {
		if ( ! file_exists( $file ) ) {
			return new WP_Error( 'spiracle_widget_missing', esc_html__( 'Widget WIE file does not exist.', 'spiraclethemes-site-library' ) );
		}

		if ( ! is_readable( $file ) ) {
			return new WP_Error( 'spiracle_widget_unreadable', esc_html__( 'Widget WIE file is not readable.', 'spiraclethemes-site-library' ) );
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$data = file_get_contents( $file );

		if ( empty( $data ) ) {
			return new WP_Error( 'spiracle_widget_empty', esc_html__( 'Widget WIE file is empty.', 'spiraclethemes-site-library' ) );
		}

		$widgets_data = json_decode( $data, true );

		if ( null === $widgets_data && JSON_ERROR_NONE !== json_last_error() ) {
			return new WP_Error( 'spiracle_widget_json_error', esc_html__( 'Widget WIE file contains invalid JSON.', 'spiraclethemes-site-library' ) );
		}

		if ( ! is_array( $widgets_data ) ) {
			return new WP_Error( 'spiracle_widget_invalid', esc_html__( 'Widget WIE file format is not valid.', 'spiraclethemes-site-library' ) );
		}

		$available_sidebars = $GLOBALS['wp_registered_sidebars'];
		$sidebars_widgets   = get_option( 'sidebars_widgets', array() );
		$widget_options     = array();

		foreach ( $widgets_data as $sidebar_id => $widgets ) {
			if ( ! isset( $available_sidebars[ $sidebar_id ] ) ) {
				continue;
			}

			if ( ! is_array( $widgets ) ) {
				continue;
			}

			if ( ! isset( $sidebars_widgets[ $sidebar_id ] ) ) {
				$sidebars_widgets[ $sidebar_id ] = array();
			}

			foreach ( $widgets as $widget_id => $widget_settings ) {
				if ( ! is_array( $widget_settings ) ) {
					continue;
				}

				$parsed = $this->parse_widget_id( $widget_id );

				if ( ! $parsed ) {
					continue;
				}

				$widget_type = $parsed['type'];
				$option_key  = 'widget_' . $widget_type;

				$valid_widget = false;
				if ( isset( $GLOBALS['wp_widget_factory'] ) ) {
					foreach ( $GLOBALS['wp_widget_factory']->widgets as $registered_widget ) {
						if ( isset( $registered_widget->id_base ) && $registered_widget->id_base === $widget_type ) {
							$valid_widget = true;
							break;
						}
					}
				}

				if ( ! $valid_widget ) {
					$existing_option = get_option( $option_key, false );
					if ( false === $existing_option ) {
						continue;
					}
				}

				if ( ! isset( $widget_options[ $option_key ] ) ) {
					$widget_options[ $option_key ] = get_option( $option_key, array() );
				}

				$next_index = $this->get_next_widget_index( $widget_options[ $option_key ] );
				$instance   = $this->sanitize_widget_instance( $widget_settings, $widget_type );

				$widget_options[ $option_key ][ $next_index ] = $instance;
				$sidebars_widgets[ $sidebar_id ][] = $widget_type . '-' . $next_index;
			}
		}

		foreach ( $widget_options as $option_key => $option_value ) {
			update_option( $option_key, $option_value );
		}

		update_option( 'sidebars_widgets', $sidebars_widgets );

		// Remap nav_menu widget term IDs using the content import term mapping.
		if ( ! empty( $term_id_map ) ) {
			$this->remap_nav_menu_widgets( $term_id_map );
		}

		return true;
	}

	/**
	 * Parse a widget ID into its base type and instance number.
	 *
	 * @param string $widget_id The widget ID string.
	 * @return array|false Associative array with 'type' and 'number', or false on failure.
	 */
	private function parse_widget_id( $widget_id ) {
		if ( preg_match( '/^(.+?)-(\d+)$/', $widget_id, $matches ) ) {
			return array(
				'type'   => $matches[1],
				'number' => (int) $matches[2],
			);
		}

		return false;
	}

	/**
	 * Get the next available index for a widget type.
	 *
	 * @param array $existing_widgets Existing widget instances for this type.
	 * @return int Next available index.
	 */
	private function get_next_widget_index( $existing_widgets ) {
		if ( empty( $existing_widgets ) ) {
			return 2;
		}

		$numeric_keys = array_filter( array_keys( $existing_widgets ), 'is_numeric' );

		if ( empty( $numeric_keys ) ) {
			return 2;
		}

		return max( $numeric_keys ) + 1;
	}

	/**
	 * Sanitize a widget instance's data.
	 *
	 * @param array  $instance_data Raw instance data.
	 * @param string $widget_type   The widget type.
	 * @return array Sanitized instance data.
	 */
	private function sanitize_widget_instance( $instance_data, $widget_type ) {
		$sanitized = array();

		foreach ( $instance_data as $key => $value ) {
			if ( is_array( $value ) ) {
				$sanitized[ $key ] = $this->sanitize_widget_instance( $value, $widget_type );
			} elseif ( is_string( $value ) ) {
				if ( in_array( $widget_type, array( 'text', 'custom_html' ), true ) && in_array( $key, array( 'text' ), true ) ) {
					$sanitized[ $key ] = wp_kses_post( $value );
				} else {
					$sanitized[ $key ] = sanitize_text_field( $value );
				}
			} else {
				$sanitized[ $key ] = $value;
			}
		}

		if ( ! isset( $sanitized['title'] ) ) {
			$sanitized['title'] = '';
		}

		return $sanitized;
	}

	/**
	 * Remap old term IDs in nav_menu widget instances to new term IDs.
	 *
	 * @param array $term_id_map Associative array of old_term_id => new_term_id.
	 */
	private function remap_nav_menu_widgets( $term_id_map ) {
		$option_key   = 'widget_nav_menu';
		$nav_menu_opts = get_option( $option_key, array() );

		if ( empty( $nav_menu_opts ) || ! is_array( $nav_menu_opts ) ) {
			return;
		}

		$changed = false;

		foreach ( $nav_menu_opts as $key => $instance ) {
			if ( ! is_array( $instance ) ) {
				continue;
			}

			if ( isset( $instance['nav_menu'] ) ) {
				$old_term_id = absint( $instance['nav_menu'] );
				if ( $old_term_id && isset( $term_id_map[ $old_term_id ] ) ) {
					$nav_menu_opts[ $key ]['nav_menu'] = absint( $term_id_map[ $old_term_id ] );
					$changed = true;
				}
			}
		}

		if ( $changed ) {
			update_option( $option_key, $nav_menu_opts );
		}
	}
}
