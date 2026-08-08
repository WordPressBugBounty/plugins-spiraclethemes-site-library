<?php
/**
 * Spiraclethemes Site Library - Demo Import Orchestrator
 *
 * Main orchestrator class for importing demo content.
 * Handles admin UI, AJAX endpoints, and coordinates content/widget/customizer imports.
 * Provides OCDI hook compatibility so existing theme functions work unchanged.
 *
 * @package spiraclethemes-site-library
 * @subpackage inc/demo-importer
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spiracle_Demo_Import {

	/**
	 * Registered demo configurations collected from pt-ocdi/import_files filter.
	 *
	 * @var array
	 */
	private $demos = array();

	/**
	 * Recommended plugins collected from ocdi/register_plugins filter.
	 *
	 * @var array
	 */
	private $recommended_plugins = array();

	/**
	 * Plugin installer instance.
	 *
	 * @var Spiracle_Plugin_Installer
	 */
	private $plugin_installer;

	/**
	 * Constructor — collects demos from OCDI hooks, registers admin page and AJAX handlers.
	 */
	public function __construct() {
		// Load plugin installer.
		$this->plugin_installer = new Spiracle_Plugin_Installer();

		// Collect demo configurations from existing theme function files.
		$this->collect_demos();

		// Collect recommended plugins on admin_init (theme files register
		// the ocdi/register_plugins filter inside admin_init callbacks,
		add_action( 'admin_init', array( $this, 'collect_plugins' ) );

		// Admin hooks.
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

		// AJAX handlers.
		add_action( 'wp_ajax_spiracle_demo_import', array( $this, 'ajax_run_import' ) );
		add_action( 'wp_ajax_spiracle_install_plugin', array( $this, 'ajax_install_plugin' ) );
		add_action( 'wp_ajax_spiracle_activate_plugin', array( $this, 'ajax_activate_plugin' ) );
		add_action( 'wp_ajax_spiracle_get_plugins_status', array( $this, 'ajax_get_plugins_status' ) );
	}

	/**
	 * Collect demo configurations from the pt-ocdi/import_files filter.
	 *
	 * This is the OCDI compatibility layer — theme function files register
	 * their demos using this filter
	 */
	private function collect_demos() {
		$demos = apply_filters( 'pt-ocdi/import_files', array() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		if ( is_array( $demos ) && ! empty( $demos ) ) {
			$this->demos = $demos;
		}
	}

	/**
	 * Collect recommended plugins from the ocdi/register_plugins filter.
	 *
	 * This is the OCDI compatibility layer — theme function files register
	 * their plugins using this filter.
	 */
	public function collect_plugins() {
		$plugins = apply_filters( 'ocdi/register_plugins', array() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		if ( is_array( $plugins ) && ! empty( $plugins ) ) {
			$this->recommended_plugins = $plugins;
		}
	}

	/**
	 * Get registered demos.
	 *
	 * @return array
	 */
	public function get_demos() {
		return $this->demos;
	}

	/**
	 * Get a single demo configuration by index.
	 *
	 * @param int $index Demo index.
	 * @return array|null Demo config or null if not found.
	 */
	public function get_demo( $index ) {
		return isset( $this->demos[ $index ] ) ? $this->demos[ $index ] : null;
	}

	/**
	 * Add admin menu page under Appearance.
	 *
	 * Uses the same menu slug as OCDI
	 */
	public function add_admin_menu() {
		add_theme_page(
			esc_html__( 'Demo Import', 'spiraclethemes-site-library' ),
			esc_html__( 'Demo Import', 'spiraclethemes-site-library' ),
			'manage_options',
			'one-click-demo-import',
			array( $this, 'render_admin_page' )
		);
	}

	/**
	 * Enqueue admin CSS/JS only on the demo import page.
	 *
	 * @param string $hook The current admin page hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( 'appearance_page_one-click-demo-import' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'spiracle-demo-import-css',
			SPIR_SITE_LIBRARY_URL . 'inc/demo-importer/assets/css/demo-import.css',
			array(),
			(string) filemtime( SPIR_SITE_LIBRARY_PATH . 'inc/demo-importer/assets/css/demo-import.css' )
		);

		wp_enqueue_script(
			'spiracle-demo-import-js',
			SPIR_SITE_LIBRARY_URL . 'inc/demo-importer/assets/js/demo-import.js',
			array( 'jquery' ),
			Spiraclethemes_Site_Library::VERSION,
			true
		);

		wp_localize_script( 'spiracle-demo-import-js', 'spiracleDemoImport', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'spiracle_demo_import_nonce' ),
			'strings' => array(
				'importing'         => esc_html__( 'Importing… Please do not close this page.', 'spiraclethemes-site-library' ),
				'step_plugins'      => esc_html__( 'Installing recommended plugins…', 'spiraclethemes-site-library' ),
				'step_content'      => esc_html__( 'Importing content…', 'spiraclethemes-site-library' ),
				'step_widgets'      => esc_html__( 'Importing widgets…', 'spiraclethemes-site-library' ),
				'step_customizer'   => esc_html__( 'Importing customizer settings…', 'spiraclethemes-site-library' ),
				'step_after'        => esc_html__( 'Running after-import setup…', 'spiraclethemes-site-library' ),
				'success'           => esc_html__( 'Demo imported successfully!', 'spiraclethemes-site-library' ),
				'error'             => esc_html__( 'Import failed.', 'spiraclethemes-site-library' ),
				'confirm'           => esc_html__( 'This will install required plugins, then import demo content, widgets, and customizer settings. Existing content may be duplicated. Continue?', 'spiraclethemes-site-library' ),
				'installing_plugin' => /* translators: %s: Plugin name */ esc_html__( 'Installing and activating %s…', 'spiraclethemes-site-library' ),
				'plugin_active'     => esc_html__( 'Active', 'spiraclethemes-site-library' ),
				'plugin_inactive'   => esc_html__( 'Inactive', 'spiraclethemes-site-library' ),
				'plugin_missing'    => esc_html__( 'Not Installed', 'spiraclethemes-site-library' ),
			),
		) );
	}

	/**
	 * Render the admin page HTML.
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$demos = $this->get_demos();
		?>
		<div class="wrap spiracle-demo-import-wrap">
			<h1 class="spiracle-demo-import-title">
				<span class="dashicons dashicons-layout"></span>
				<?php esc_html_e( 'Demo Import', 'spiraclethemes-site-library' ); ?>
			</h1>
			<p class="spiracle-demo-import-description">
				<?php esc_html_e( 'Select a demo and click Import to install recommended plugins, demo content, widgets, and customizer settings.', 'spiraclethemes-site-library' ); ?>
			</p>

			<?php if ( empty( $demos ) ) : ?>
				<div class="spiracle-no-demos">
					<span class="dashicons dashicons-info"></span>
					<h3><?php esc_html_e( 'No Demos Available', 'spiraclethemes-site-library' ); ?></h3>
					<p><?php esc_html_e( 'No demo configurations were found for the current theme. Please make sure the theme is compatible with Spiraclethemes Site Library.', 'spiraclethemes-site-library' ); ?></p>
				</div>
			<?php else : ?>
				<div class="spiracle-demo-grid">
					<?php foreach ( $demos as $index => $demo ) :
						$preview_image_url = ! empty( $demo['import_preview_image_url'] ) ? $demo['import_preview_image_url'] : '';
						$demo_name         = ! empty( $demo['import_file_name'] ) ? $demo['import_file_name'] : sprintf( /* translators: %d: Demo number */ __( 'Demo %d', 'spiraclethemes-site-library' ), $index + 1 );
						$notice            = ! empty( $demo['import_notice'] ) ? $demo['import_notice'] : '';
						$preview_url       = ! empty( $demo['preview_url'] ) ? $demo['preview_url'] : '';
						$has_content       = ! empty( $demo['import_file_url'] );
						$has_widgets       = ! empty( $demo['import_widget_file_url'] );
						$has_customizer    = ! empty( $demo['import_customizer_file_url'] );
						$all_files_exist   = $has_content && $has_widgets && $has_customizer;

						// Check recommended plugins status.
						$plugin_statuses = array();
						$all_plugins_ok  = true;
						if ( ! empty( $this->recommended_plugins ) ) {
							foreach ( $this->recommended_plugins as $plugin ) {
								$status              = $this->plugin_installer->check_plugin_status( $plugin );
								$plugin_statuses[]   = $status;
								if ( $status['required'] && 'active' !== $status['status'] ) {
									$all_plugins_ok = false;
								}
							}
						}
						?>
						<div class="spiracle-demo-card" data-index="<?php echo esc_attr( $index ); ?>">
							<div class="spiracle-demo-card-preview">
								<?php if ( $preview_image_url ) : ?>
									<img src="<?php echo esc_url( $preview_image_url ); ?>" alt="<?php echo esc_attr( $demo_name ); ?>" />
								<?php else : ?>
									<div class="spiracle-demo-card-placeholder">
										<span class="dashicons dashicons-layout"></span>
									</div>
								<?php endif; ?>
							</div>
							<div class="spiracle-demo-card-body">
								<h3 class="spiracle-demo-card-name"><?php echo esc_html( $demo_name ); ?></h3>

								<?php if ( ! empty( $notice ) ) : ?>
									<p class="spiracle-demo-card-notice"><?php echo esc_html( $notice ); ?></p>
								<?php endif; ?>

								<div class="spiracle-demo-card-files">
									<span class="spiracle-file-status <?php echo $has_content ? 'status-ok' : 'status-missing'; ?>">
										<span class="dashicons <?php echo $has_content ? 'dashicons-yes-alt' : 'dashicons-warning'; ?>"></span>
										<?php esc_html_e( 'Content', 'spiraclethemes-site-library' ); ?>
									</span>
									<span class="spiracle-file-status <?php echo $has_widgets ? 'status-ok' : 'status-missing'; ?>">
										<span class="dashicons <?php echo $has_widgets ? 'dashicons-yes-alt' : 'dashicons-warning'; ?>"></span>
										<?php esc_html_e( 'Widgets', 'spiraclethemes-site-library' ); ?>
									</span>
									<span class="spiracle-file-status <?php echo $has_customizer ? 'status-ok' : 'status-missing'; ?>">
										<span class="dashicons <?php echo $has_customizer ? 'dashicons-yes-alt' : 'dashicons-warning'; ?>"></span>
										<?php esc_html_e( 'Customizer', 'spiraclethemes-site-library' ); ?>
									</span>
								</div>

								<?php if ( ! empty( $plugin_statuses ) ) : ?>
									<div class="spiracle-demo-card-plugins">
										<h4 class="spiracle-plugins-heading">
											<span class="dashicons dashicons-admin-plugins"></span>
											<?php esc_html_e( 'Required Plugins', 'spiraclethemes-site-library' ); ?>
										</h4>
										<div class="spiracle-plugins-list">
											<?php foreach ( $plugin_statuses as $ps ) : ?>
												<div class="spiracle-plugin-item" data-plugin-slug="<?php echo esc_attr( $ps['slug'] ); ?>">
													<span class="spiracle-plugin-status-indicator spiracle-plugin-<?php echo esc_attr( $ps['status'] ); ?>">
														<?php
														switch ( $ps['status'] ) {
															case 'active':
																echo '<span class="dashicons dashicons-yes-alt"></span>';
																break;
															case 'inactive':
																echo '<span class="dashicons dashicons-marker"></span>';
																break;
															default:
																echo '<span class="dashicons dashicons-warning"></span>';
														}
														?>
													</span>
													<span class="spiracle-plugin-name"><?php echo esc_html( $ps['name'] ); ?></span>
													<span class="spiracle-plugin-badge spiracle-badge-<?php echo esc_attr( $ps['status'] ); ?>">
														<?php
														switch ( $ps['status'] ) {
															case 'active':
																esc_html_e( 'Active', 'spiraclethemes-site-library' );
																break;
															case 'inactive':
																esc_html_e( 'Inactive', 'spiraclethemes-site-library' );
																break;
															default:
																esc_html_e( 'Not Installed', 'spiraclethemes-site-library' );
														}
														?>
													</span>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>

								<div class="spiracle-demo-card-actions">
									<?php if ( $all_files_exist || $has_content ) : ?>
										<button class="button button-primary button-large spiracle-import-btn" data-demo="<?php echo esc_attr( $index ); ?>">
											<span class="dashicons dashicons-download"></span>
											<?php esc_html_e( 'Import Demo', 'spiraclethemes-site-library' ); ?>
										</button>
									<?php else : ?>
										<button class="button button-large" disabled>
											<span class="dashicons dashicons-warning"></span>
											<?php esc_html_e( 'Files Missing', 'spiraclethemes-site-library' ); ?>
										</button>
									<?php endif; ?>

									<?php if ( $preview_url && '#' !== $preview_url ) : ?>
										<a href="<?php echo esc_url( $preview_url ); ?>" target="_blank" class="button button-large spiracle-preview-btn">
											<span class="dashicons dashicons-external"></span>
											<?php esc_html_e( 'Live Preview', 'spiraclethemes-site-library' ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- Progress overlay -->
				<div id="spiracle-import-overlay" style="display:none;">
					<div class="spiracle-import-modal">
						<button type="button" class="spiracle-modal-close" id="spiracle-modal-close-btn" style="display:none;">
							<span class="dashicons dashicons-no-alt"></span>
						</button>
						<h2 id="spiracle-modal-title"><?php esc_html_e( 'Importing Demo', 'spiraclethemes-site-library' ); ?></h2>
						<div class="spiracle-import-progress-bar">
							<div class="spiracle-import-progress-fill" id="spiracle-progress-fill"></div>
						</div>
						<ul class="spiracle-import-steps" id="spiracle-import-steps">
							<li class="spiracle-step-item" data-step="plugins">
								<span class="spiracle-step-text"><?php esc_html_e( 'Installing recommended plugins…', 'spiraclethemes-site-library' ); ?></span>
								<span class="spiracle-step-status"></span>
							</li>
							<li class="spiracle-step-item" data-step="content">
								<span class="spiracle-step-text"><?php esc_html_e( 'Importing content…', 'spiraclethemes-site-library' ); ?></span>
								<span class="spiracle-step-status"></span>
							</li>
							<li class="spiracle-step-item" data-step="widgets">
								<span class="spiracle-step-text"><?php esc_html_e( 'Importing widgets…', 'spiraclethemes-site-library' ); ?></span>
								<span class="spiracle-step-status"></span>
							</li>
							<li class="spiracle-step-item" data-step="customizer">
								<span class="spiracle-step-text"><?php esc_html_e( 'Importing customizer settings…', 'spiraclethemes-site-library' ); ?></span>
								<span class="spiracle-step-status"></span>
							</li>
							<li class="spiracle-step-item" data-step="after_import">
								<span class="spiracle-step-text"><?php esc_html_e( 'Running after-import setup…', 'spiraclethemes-site-library' ); ?></span>
								<span class="spiracle-step-status"></span>
							</li>
						</ul>
						<div class="spiracle-import-log" id="spiracle-import-log"></div>
						<div class="spiracle-modal-actions" id="spiracle-modal-actions" style="display:none;">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="button button-primary button-large spiracle-visit-site-btn">
								<span class="dashicons dashicons-external"></span>
								<?php esc_html_e( 'Visit Website', 'spiraclethemes-site-library' ); ?>
							</a>
							<button type="button" class="button button-large spiracle-close-btn" id="spiracle-close-popup-btn">
								<?php esc_html_e( 'Close', 'spiraclethemes-site-library' ); ?>
							</button>
						</div>
					</div>
				</div>
		</div>
		<?php
	}

	/**
	 * Download a remote file to a temporary location.
	 *
	 * @param string $url The URL to download.
	 * @return string|WP_Error Temporary file path on success, WP_Error on failure.
	 */
	private function download_file( $url ) {
		if ( empty( $url ) ) {
			return new WP_Error( 'spiracle_empty_url', esc_html__( 'File URL is empty.', 'spiraclethemes-site-library' ) );
		}

		$local_path = $this->resolve_local_file_path( $url );
		if ( $local_path && file_exists( $local_path ) && is_readable( $local_path ) ) {
			return $local_path;
		}

		$scheme = wp_parse_url( $url, PHP_URL_SCHEME );
		if ( ! in_array( $scheme, array( 'http', 'https' ), true ) ) {
			return new WP_Error( 'spiracle_invalid_url_scheme', esc_html__( 'Only http:// and https:// URLs are allowed for file downloads.', 'spiraclethemes-site-library' ) );
		}

		$host = wp_parse_url( $url, PHP_URL_HOST );
		if ( ! $host ) {
			return new WP_Error( 'spiracle_invalid_url_host', esc_html__( 'Invalid URL: missing host.', 'spiraclethemes-site-library' ) );
		}

		$is_local = $this->is_local_host( $host );

		if ( ! $is_local ) {
			$resolved_ip = gethostbyname( $host );
			if ( $resolved_ip === $host ) {
				return new WP_Error( 'spiracle_unresolvable_host', esc_html__( 'Could not resolve download URL host.', 'spiraclethemes-site-library' ) );
			}

			$private_ip_patterns = array(
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
			);

			foreach ( $private_ip_patterns as $pattern ) {
				if ( preg_match( $pattern, $resolved_ip ) ) {
					return new WP_Error( 'spiracle_private_ip', esc_html__( 'Downloads from private/internal networks are not allowed.', 'spiraclethemes-site-library' ) );
				}
			}
		}

		require_once ABSPATH . 'wp-admin/includes/file.php';

		// Pin DNS to the validated IP to prevent DNS-rebinding (TOCTOU) attacks.
		// Without this, download_url() re-resolves the host independently and an
		// attacker with a low-TTL DNS record could return a public IP on our
		// gethostbyname() check above, then a private IP for the actual download.
		$spir_dns_pin = null;
		if ( ! $is_local && ! empty( $resolved_ip ) && function_exists( 'curl_init' ) ) {
			$spir_dns_pin = function ( $handle ) use ( $host, $resolved_ip ) {
				curl_setopt( $handle, CURLOPT_RESOLVE, array(
					$host . ':80:'  . $resolved_ip,
					$host . ':443:' . $resolved_ip,
				) );
			};
			add_action( 'http_api_curl', $spir_dns_pin, 10, 1 );
		}

		$tmp = download_url( $url, 120 );

		// Always remove the pin so it doesn't leak into other requests.
		if ( $spir_dns_pin ) {
			remove_action( 'http_api_curl', $spir_dns_pin, 10 );
		}

		if ( is_wp_error( $tmp ) ) {
			return $tmp;
		}

		return $tmp;
	}

	private function resolve_local_file_path( $url ) {
		$site_url = site_url( '/' );
		$site_path = wp_parse_url( $site_url, PHP_URL_PATH );

		$url_path = wp_parse_url( $url, PHP_URL_PATH );
		if ( ! $url_path ) {
			return '';
		}

		$url_host = wp_parse_url( $url, PHP_URL_HOST );
		$site_host = wp_parse_url( $site_url, PHP_URL_HOST );

		if ( $url_host && $site_host && $url_host !== $site_host ) {
			if ( ! $this->is_local_host( $url_host ) || ! $this->is_local_host( $site_host ) ) {
				return '';
			}
		}

		if ( $site_path && 0 === strpos( $url_path, $site_path ) ) {
			$relative = substr( $url_path, strlen( $site_path ) );
		} else {
			$relative = ltrim( $url_path, '/' );
		}

		$absolute = ABSPATH . $relative;

		$real_base = realpath( ABSPATH );
		$real_file = realpath( dirname( $absolute ) );

		if ( $real_base && $real_file && 0 !== strpos( $real_file, $real_base ) ) {
			return '';
		}

		return $absolute;
	}

	private function cleanup_file( $file ) {
		$tmp_dir = get_temp_dir();
		$tmp_dir_real = realpath( $tmp_dir );
		$file_real = realpath( $file );

		if ( $tmp_dir_real && $file_real && 0 === strpos( $file_real, $tmp_dir_real ) ) {
			wp_delete_file( $file );
		}
	}

	private function is_local_host( $host ) {
		$local_patterns = array(
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
		);

		foreach ( $local_patterns as $pattern ) {
			if ( preg_match( $pattern, $host ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * AJAX handler — runs the full import process step by step.
	 *
	 * Expects POST parameters:
	 *   - nonce  : Security nonce.
	 *   - demo   : Demo index.
	 *   - step   : Current step (plugins, content, widgets, customizer, after_import).
	 */
	public function ajax_run_import() {
		ob_start();
		@ini_set( 'display_errors', 0 );

		$this->register_shutdown_handler();

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'spiracle_demo_import_nonce' ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'Security check failed.', 'spiraclethemes-site-library' ) ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'You do not have sufficient permissions.', 'spiraclethemes-site-library' ) ) );
		}

		$demo_index = isset( $_POST['demo'] ) ? absint( $_POST['demo'] ) : -1;
		$step       = isset( $_POST['step'] ) ? sanitize_key( $_POST['step'] ) : 'plugins';

		$demo = $this->get_demo( $demo_index );
		if ( ! $demo ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid demo selected.', 'spiraclethemes-site-library' ) ) );
		}

		if ( function_exists( 'set_time_limit' ) && false === strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) ) {
			@set_time_limit( 1800 );
		}

		if ( function_exists( 'wp_raise_memory_limit' ) ) {
			wp_raise_memory_limit( 'admin' );
		} else {
			$current = wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) );
			$needed  = 512 * MB_IN_BYTES;
			if ( $current < $needed ) {
				@ini_set( 'memory_limit', '512M' );
			}
		}

		$result = array();

		switch ( $step ) {
			case 'plugins':
				$result = $this->install_recommended_plugins();
				break;

			case 'content':
				if ( ! empty( $demo['import_file_url'] ) ) {
					$result = $this->import_content( $demo['import_file_url'] );
				} else {
					$result = array(
						'message' => esc_html__( 'No content file to import, skipping.', 'spiraclethemes-site-library' ),
						'next'    => 'widgets',
					);
				}
				break;

			case 'widgets':
				if ( ! empty( $demo['import_widget_file_url'] ) ) {
					$result = $this->import_widgets( $demo['import_widget_file_url'] );
				} else {
					$result = array(
						'message' => esc_html__( 'No widget file to import, skipping.', 'spiraclethemes-site-library' ),
						'next'    => 'customizer',
					);
				}
				break;

			case 'customizer':
				if ( ! empty( $demo['import_customizer_file_url'] ) ) {
					$result = $this->import_customizer( $demo['import_customizer_file_url'] );
				} else {
					$result = array(
						'message' => esc_html__( 'No customizer file to import, skipping.', 'spiraclethemes-site-library' ),
						'next'    => 'after_import',
					);
				}
				break;

			case 'after_import':
				$result = $this->after_import_setup( $demo_index );
				break;

			default:
				ob_end_clean();
				wp_send_json_error( array( 'message' => esc_html__( 'Invalid import step.', 'spiraclethemes-site-library' ) ) );
		}

		if ( is_wp_error( $result ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		ob_end_clean();
		wp_send_json_success( $result );
	}

	private function register_shutdown_handler() {
		$buffer_level = ob_get_level();

		register_shutdown_function( function () use ( $buffer_level ) {
			$error = error_get_last();
			if ( ! $error || ! in_array( $error['type'], array( E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR ), true ) ) {
				return;
			}

			while ( ob_get_level() > $buffer_level ) {
				ob_end_clean();
			}

			if ( ! headers_sent() ) {
				header( 'Content-Type: application/json; charset=UTF-8' );
			}

			// Log the full error detail server-side for debugging.
			if ( function_exists( 'error_log' ) ) {
				error_log( sprintf(
					'Spiraclethemes Demo Import fatal error: %s in %s on line %d',
					$error['message'],
					$error['file'],
					$error['line']
				) );
			}

			echo wp_json_encode( array(
				'success' => false,
				'data'    => array(
					'message' => esc_html__( 'A server error occurred during import. Please check your PHP error log for details.', 'spiraclethemes-site-library' ),
				),
			) );
		} );
	}

	/**
	 * Install and activate recommended plugins.
	 *
	 * @return array|WP_Error Result array on success, WP_Error on failure.
	 */
	private function install_recommended_plugins() {
		$plugins = $this->recommended_plugins;
		$errors  = array();

		foreach ( $plugins as $plugin ) {
			$result = $this->plugin_installer->install_and_activate( $plugin['slug'] );

			if ( is_wp_error( $result ) ) {
				$errors[] = sprintf(
					/* translators: 1: Plugin name 2: Error message */
					__( 'Plugin "%1$s": %2$s', 'spiraclethemes-site-library' ),
					$plugin['name'],
					$result->get_error_message()
				);
			}
		}

		if ( ! empty( $errors ) ) {
			return new WP_Error(
				'spiracle_plugin_install_errors',
				sprintf(
					/* translators: %s: Error messages */
					__( 'Some plugins could not be installed: %s', 'spiraclethemes-site-library' ),
					implode( '; ', $errors )
				)
			);
		}

		return array(
			'message' => esc_html__( 'All recommended plugins installed and activated.', 'spiraclethemes-site-library' ),
			'next'    => 'content',
		);
	}

	/**
	 * AJAX handler — install a single plugin.
	 */
	public function ajax_install_plugin() {
		ob_start();

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'spiracle_demo_import_nonce' ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'Security check failed.', 'spiraclethemes-site-library' ) ) );
		}

		if ( ! current_user_can( 'install_plugins' ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to install plugins.', 'spiraclethemes-site-library' ) ) );
		}

		$slug = isset( $_POST['slug'] ) ? sanitize_key( $_POST['slug'] ) : '';
		if ( empty( $slug ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'Plugin slug is required.', 'spiraclethemes-site-library' ) ) );
		}

		$allowed_slugs = wp_list_pluck( $this->recommended_plugins, 'slug' );
		if ( ! in_array( $slug, $allowed_slugs, true ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'This plugin is not in the recommended plugins list.', 'spiraclethemes-site-library' ) ) );
		}

		$result = $this->plugin_installer->install_and_activate( $slug );

		if ( is_wp_error( $result ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		ob_end_clean();
		wp_send_json_success( $result );
	}

	/**
	 * AJAX handler — activate a single plugin.
	 */
	public function ajax_activate_plugin() {
		ob_start();

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'spiracle_demo_import_nonce' ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'Security check failed.', 'spiraclethemes-site-library' ) ) );
		}

		if ( ! current_user_can( 'activate_plugins' ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to activate plugins.', 'spiraclethemes-site-library' ) ) );
		}

		$slug = isset( $_POST['slug'] ) ? sanitize_key( $_POST['slug'] ) : '';
		if ( empty( $slug ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'Plugin slug is required.', 'spiraclethemes-site-library' ) ) );
		}

		$allowed_slugs = wp_list_pluck( $this->recommended_plugins, 'slug' );
		if ( ! in_array( $slug, $allowed_slugs, true ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'This plugin is not in the recommended plugins list.', 'spiraclethemes-site-library' ) ) );
		}

		$result = $this->plugin_installer->activate_plugin( $slug );

		if ( is_wp_error( $result ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		ob_end_clean();
		wp_send_json_success( $result );
	}

	/**
	 * AJAX handler — get the status of recommended plugins.
	 */
	public function ajax_get_plugins_status() {
		ob_start();

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'spiracle_demo_import_nonce' ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'Security check failed.', 'spiraclethemes-site-library' ) ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			ob_end_clean();
			wp_send_json_error( array( 'message' => esc_html__( 'You do not have sufficient permissions.', 'spiraclethemes-site-library' ) ) );
		}

		$statuses = array();
		foreach ( $this->recommended_plugins as $plugin ) {
			$statuses[] = $this->plugin_installer->check_plugin_status( $plugin );
		}

		ob_end_clean();
		wp_send_json_success( array( 'plugins' => $statuses ) );
	}

	/**
	 * Import WordPress content from a remote XML file.
	 *
	 * After import, the old-to-new post ID mapping is saved to a transient
	 * so the customizer import step can remap attachment IDs.
	 *
	 * @param string $url URL to the XML file.
	 * @return array|WP_Error Result array on success, WP_Error on failure.
	 */
	private function import_content( $url ) {
		$tmp_file = $this->download_file( $url );

		if ( is_wp_error( $tmp_file ) ) {
			return $tmp_file;
		}

		$importer = new Spiracle_Content_Importer();
		$result   = $importer->import( $tmp_file );

		// Save the post ID mapping for the customizer import step.
		$post_id_map = $importer->get_post_id_map();
		if ( ! empty( $post_id_map ) ) {
			set_transient( 'spiracle_demo_import_post_id_map', $post_id_map, HOUR_IN_SECONDS );
		}

		// Save the term ID mapping for the widget import step (nav_menu widget remapping).
		$term_id_map = $importer->get_term_id_map();
		if ( ! empty( $term_id_map ) ) {
			set_transient( 'spiracle_demo_import_term_id_map', $term_id_map, HOUR_IN_SECONDS );
		}

		// Clean up temp file.
		$this->cleanup_file( $tmp_file );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		return array(
			'message' => esc_html__( 'Content imported successfully.', 'spiraclethemes-site-library' ),
			'next'    => 'widgets',
		);
	}

	/**
	 * Import widgets from a remote WIE file.
	 *
	 * @param string $url URL to the WIE file.
	 * @return array|WP_Error Result array on success, WP_Error on failure.
	 */
	private function import_widgets( $url ) {
		$tmp_file = $this->download_file( $url );

		if ( is_wp_error( $tmp_file ) ) {
			return $tmp_file;
		}

		$importer = new Spiracle_Widget_Importer();

		// Retrieve the term ID mapping from the content import step for nav_menu widget remapping.
		$term_id_map = get_transient( 'spiracle_demo_import_term_id_map' );
		if ( ! is_array( $term_id_map ) ) {
			$term_id_map = array();
		}

		$result = $importer->import( $tmp_file, $term_id_map );

		// Clean up term ID map transient.
		delete_transient( 'spiracle_demo_import_term_id_map' );

		// Clean up temp file.
		$this->cleanup_file( $tmp_file );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		return array(
			'message' => esc_html__( 'Widgets imported successfully.', 'spiraclethemes-site-library' ),
			'next'    => 'customizer',
		);
	}

	/**
	 * Import customizer settings from a remote DAT file.
	 *
	 * Retrieves the post ID mapping saved by the content import step
	 * and passes it to the customizer importer for attachment ID remapping.
	 *
	 * @param string $url URL to the DAT file.
	 * @return array|WP_Error Result array on success, WP_Error on failure.
	 */
	private function import_customizer( $url ) {
		$tmp_file = $this->download_file( $url );

		if ( is_wp_error( $tmp_file ) ) {
			return $tmp_file;
		}

		// Retrieve the post ID mapping from the content import step.
		$post_id_map = get_transient( 'spiracle_demo_import_post_id_map' );
		if ( ! is_array( $post_id_map ) ) {
			$post_id_map = array();
		}

		$importer = new Spiracle_Customizer_Importer();
		$result   = $importer->import( $tmp_file, $post_id_map );

		// Clean up transient and temp file.
		delete_transient( 'spiracle_demo_import_post_id_map' );
		delete_transient( 'spiracle_demo_import_term_id_map' );
		$this->cleanup_file( $tmp_file );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		return array(
			'message' => esc_html__( 'Customizer settings imported successfully.', 'spiraclethemes-site-library' ),
			'next'    => 'after_import',
		);
	}

	/**
	 * Run after-import setup tasks.
	 *
	 * Fires the pt-ocdi/after_import action so existing theme function files
	 * can run their after-import setup (menu assignments, front page, etc.)
	 * without any changes.
	 *
	 * @param int $demo_index The selected demo index.
	 * @return array Result array.
	 */
	private function after_import_setup( $demo_index ) {
		// Build a mock selected_import object compatible with OCDI format.
		$selected_import = $this->get_demo( $demo_index );
		if ( ! $selected_import ) {
			$selected_import = array();
		}

		// Add the index for themes that reference it.
		$selected_import['import_index'] = $demo_index;

		/**
		 * Fire the OCDI after-import action.
		 *
		 * This is the compatibility layer — theme function files hook into
		 * pt-ocdi/after_import to set up menus, front page, etc.
		 *
		 * @param array $selected_import The selected demo configuration.
		 */
		do_action( 'pt-ocdi/after_import', $selected_import ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

		// Flush Elementor cache.
		$this->flush_elementor_cache();

		return array(
			'message' => esc_html__( 'After-import setup completed successfully.', 'spiraclethemes-site-library' ),
			'next'    => 'done',
		);
	}

	/**
	 * Flush all Elementor caches after a demo import.
	 */
	private function flush_elementor_cache() {
		if ( class_exists( '\Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}

		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->delete(
			$wpdb->postmeta,
			array( 'meta_key' => '_elementor_element_cache' ),
			array( '%s' )
		);
	}
}
