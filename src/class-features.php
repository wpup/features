<?php

namespace WPUP\Features;

class Features {
	/**
	 * Array of features for setting page.
	 *
	 * @var array
	 */
	protected $features;

	/**
	 * Features instance.
	 *
	 * @var \WPUP\Features\Features
	 */
	protected static $instance;

	/**
	 * Get routes instance.
	 *
	 * @return \WPUP\Features\Features
	 */
	public static function instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 * Features constructor.
	 */
	protected function __construct() {
		$this->load_textdomain();
		$this->enable_features();

		// Add action to save features.
		add_action( 'admin_init', [$this, 'save_features'] );

		// Add action to add new admin menu item.
		add_action( 'admin_menu', [$this, 'admin_menu'] );
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$parent     = 'options-general.php';
		$title      = esc_html__( 'Features', 'features' );
		$capability = apply_filters( 'features_capability', 'administrator' );
		$slug       = 'features';
		$features   = $this->features;
		$labels     = apply_filters( 'features_labels', [] );

		add_submenu_page( $parent, $title, $title, $capability, $slug, function () use ( $features, $labels ) {
			require_once __DIR__ . '/views/admin.php';
		} );
	}

	/**
	 * Enable features that are saved in the database.
	 */
	public function enable_features() {
		$features  = features()->getData();
		$features2 = get_option( 'features', [] );

		foreach ( $features as $key => $value ) {
			if ( ! isset( $features2[$key] ) ) {
				$this->features[$key] = features()->enabled( $key );
				continue;
			}

			if ( boolval( $features2[$key] ) ) {
				features()->enable( $key );
				$this->features[$key] = true;
			} else {
				features()->disable( $key );
				$this->features[$key] = false;
			}
		}
	}

	/**
	 * Load Localisation files.
	 *
	 * Locales found in:
	 * - WP_LANG_DIR/features/features-LOCALE.mo
	 * - WP_CONTENT_DIR/[mu-]plugins/features/languages/features-LOCALE.mo
	 */
	protected function load_textdomain() {
		$locale = function_exists( 'get_user_local' ) ? get_user_local() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'features' );
		load_textdomain( 'features', WP_LANG_DIR . '/features/features-' . $locale . '.mo' );
		$mu_dir = trailingslashit( sprintf( '%s/%s/src', WPMU_PLUGIN_DIR, basename( dirname( __DIR__ ) ) ) );
		$mu_dir = is_dir( $mu_dir ) ? $mu_dir : trailingslashit( __DIR__ );
		load_textdomain( 'features', $mu_dir . '../languages/features-' . $locale . '.mo' );
	}

	/**
	 * Save features from admin.
	 */
	public function save_features() {
		// Bail if not a post request method.
		if ( $_SERVER ['REQUEST_METHOD'] !== 'POST' ) {
			return;
		}

		// Bail if bad nonce.
		if ( empty( $_POST['features_nonce'] ) || ! wp_verify_nonce( $_POST['features_nonce'], 'features_update' ) ) {
			return;
		}

		update_option( 'features', $_POST['features'] );
	}
}
