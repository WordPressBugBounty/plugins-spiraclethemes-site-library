<?php
/**
 * Spiraclethemes Site Library - Plugin Installer
 *
 * Handles checking, installing, and activating recommended plugins
 * required for demo content to work properly.
 *
 * @package spiraclethemes-site-library
 * @subpackage inc/demo-importer
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spiracle_Plugin_Installer {

	/**
	 * Check the status of a single plugin.
	 *
	 * @param array $plugin Plugin configuration array (name, slug, required).
	 * @return array Plugin status info.
	 */
	public function check_plugin_status( $plugin ) {
		$status = 'not_installed';

		$plugin_path = $this->get_plugin_path( $plugin['slug'] );

		if ( $plugin_path ) {
			if ( is_plugin_active( $plugin_path ) ) {
				$status = 'active';
			} else {
				$status = 'inactive';
			}
		}

		$install_url  = '';
		$activate_url = '';

		if ( 'not_installed' === $status ) {
			$install_url = admin_url( 'plugin-install.php?tab=search&s=' . urlencode( $plugin['slug'] ) );
		} elseif ( 'inactive' === $status ) {
			$activate_url = wp_nonce_url(
				add_query_arg(
					array(
						'action' => 'activate',
						'plugin' => $plugin_path,
					),
					admin_url( 'plugins.php' )
				),
				'activate-plugin_' . $plugin_path
			);
		}

		return array(
			'slug'         => $plugin['slug'],
			'name'         => $plugin['name'],
			'required'     => ! empty( $plugin['required'] ),
			'status'       => $status,
			'install_url'  => $install_url,
			'activate_url' => $activate_url,
		);
	}

	/**
	 * Install a plugin from the WordPress.org repository.
	 *
	 * @param string $slug Plugin slug.
	 * @return array|WP_Error Result array on success, WP_Error on failure.
	 */
	public function install_plugin( $slug ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return new WP_Error(
				'spiracle_plugin_install_permission',
				esc_html__( 'You do not have permission to install plugins.', 'spiraclethemes-site-library' )
			);
		}

		$existing_path = $this->get_plugin_path( $slug );
		if ( $existing_path ) {
			return array(
				'message' => sprintf(
					/* translators: %s: Plugin slug */
					esc_html__( '%s is already installed.', 'spiraclethemes-site-library' ),
					$slug
				),
				'status'  => 'already_installed',
			);
		}

		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

		$api = plugins_api(
			'plugin_information',
			array(
				'slug'   => $slug,
				'fields' => array(
					'short_description' => false,
					'sections'          => false,
					'requires'          => false,
					'rating'            => false,
					'ratings'           => false,
					'downloaded'        => false,
					'last_updated'      => false,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
				),
			)
		);

		if ( is_wp_error( $api ) ) {
			return new WP_Error(
				'spiracle_plugin_api_error',
				sprintf(
					/* translators: %s: Plugin slug */
					esc_html__( 'Could not find plugin information for "%s" on WordPress.org.', 'spiraclethemes-site-library' ),
					$slug
				)
			);
		}

		$skin     = new WP_Ajax_Upgrader_Skin();
		$upgrader = new Plugin_Upgrader( $skin );
		$result   = $upgrader->install( $api->download_link );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		if ( ! $result ) {
			return new WP_Error(
				'spiracle_plugin_install_failed',
				sprintf(
					/* translators: %s: Plugin slug */
					esc_html__( 'Failed to install plugin "%s".', 'spiraclethemes-site-library' ),
					$slug
				)
			);
		}

		$skin_errors = $skin->get_errors();
		if ( $skin_errors->has_errors() ) {
			return new WP_Error(
				'spiracle_plugin_install_skin_error',
				$skin_errors->get_error_message()
			);
		}

		return array(
			'message' => sprintf(
				/* translators: %s: Plugin slug */
				esc_html__( 'Plugin "%s" installed successfully.', 'spiraclethemes-site-library' ),
				$slug
			),
			'status'  => 'installed',
		);
	}

	/**
	 * Activate a plugin by its slug.
	 *
	 * @param string $slug Plugin slug.
	 * @return array|WP_Error Result array on success, WP_Error on failure.
	 */
	public function activate_plugin( $slug ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return new WP_Error(
				'spiracle_plugin_activate_permission',
				esc_html__( 'You do not have permission to activate plugins.', 'spiraclethemes-site-library' )
			);
		}

		$plugin_path = $this->get_plugin_path( $slug );

		if ( ! $plugin_path ) {
			return new WP_Error(
				'spiracle_plugin_not_found',
				sprintf(
					/* translators: %s: Plugin slug */
					esc_html__( 'Plugin "%s" is not installed.', 'spiraclethemes-site-library' ),
					$slug
				)
			);
		}

		if ( is_plugin_active( $plugin_path ) ) {
			return array(
				'message' => sprintf(
					/* translators: %s: Plugin slug */
					esc_html__( 'Plugin "%s" is already active.', 'spiraclethemes-site-library' ),
					$slug
				),
				'status'  => 'already_active',
			);
		}

		$activated = activate_plugin( $plugin_path );

		if ( is_wp_error( $activated ) ) {
			return $activated;
		}

		return array(
			'message' => sprintf(
				/* translators: %s: Plugin slug */
				esc_html__( 'Plugin "%s" activated successfully.', 'spiraclethemes-site-library' ),
				$slug
			),
			'status'  => 'activated',
		);
	}

	/**
	 * Install and activate a plugin by slug.
	 *
	 * @param string $slug Plugin slug.
	 * @return array|WP_Error Result array on success, WP_Error on failure.
	 */
	public function install_and_activate( $slug ) {
		$existing_path = $this->get_plugin_path( $slug );
		if ( $existing_path && is_plugin_active( $existing_path ) ) {
			return array(
				'message' => sprintf(
					/* translators: %s: Plugin slug */
					esc_html__( 'Plugin "%s" is already installed and active.', 'spiraclethemes-site-library' ),
					$slug
				),
				'status' => 'already_active',
			);
		}

		if ( ! $existing_path ) {
			$install_result = $this->install_plugin( $slug );
			if ( is_wp_error( $install_result ) ) {
				return $install_result;
			}
		}

		$activate_result = $this->activate_plugin( $slug );
		if ( is_wp_error( $activate_result ) ) {
			return $activate_result;
		}

		return array(
			'message' => sprintf(
				/* translators: %s: Plugin slug */
				esc_html__( 'Plugin "%s" installed and activated successfully.', 'spiraclethemes-site-library' ),
				$slug
			),
			'status' => 'activated',
		);
	}

	/**
	 * Get the main plugin file path for a given slug.
	 *
	 * @param string $slug Plugin slug (directory name).
	 * @return string|false Plugin path relative to plugins directory, or false if not found.
	 */
	public function get_plugin_path( $slug ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugins = get_plugins();

		if ( isset( $plugins[ $slug . '/' . $slug . '.php' ] ) ) {
			return $slug . '/' . $slug . '.php';
		}

		foreach ( $plugins as $plugin_path => $plugin_data ) {
			$path_parts = explode( '/', $plugin_path );
			if ( isset( $path_parts[0] ) && $path_parts[0] === $slug ) {
				return $plugin_path;
			}
		}

		return false;
	}
}
