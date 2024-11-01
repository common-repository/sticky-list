<?php
/**
 * Assets Manager Class
 *
 * @package StickyList
 * @since 1.0.0
 */

namespace ultraDevs\SL;

use ultraDevs\SL\Admin\Dashboard;
use ultraDevs\SL\Helper;

/**
 * Manage All Assets
 *
 * This class is for managing Assets
 *
 * @package StickyList
 * @since 1.0.0
 */
class Assets_Manager {

	/**
	 * Admin Assets
	 *
	 * Enqueue Admin Styles and Scripts
	 */
	public function admin_assets() {

		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		wp_enqueue_style( 'sticky-list-admin', STICKY_LIST_ASSETS . 'admin/index.css', array( 'wp-components' ), STICKY_LIST_VERSION );

		$script_assets = require_once STICKY_LIST_DIR_PATH . 'assets/admin/index.asset.php';

		wp_enqueue_script( 'sticky-list-admin', STICKY_LIST_ASSETS . 'admin/index.js', $script_assets['dependencies'], $script_assets['version'], true );

		wp_localize_script(
			'sticky-list-admin',
			'SLAdmin',
			array(
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
				'version'    => STICKY_LIST_VERSION,
				'assets'     => STICKY_LIST_ASSETS,
				'isPro'      => sl_fs()->can_use_premium_code(),
				'upgradeUrl' => sl_fs()->get_upgrade_url(),
			)
		);
		/**
		 * Font Awesome
		 */
		wp_enqueue_style( 'font-awesome', STICKY_LIST_ASSETS . 'vendor/font-awesome/css/all.min.css', '', STICKY_LIST_VERSION );
		/**
		 * Font Icon Picker
		 */
		wp_enqueue_style( 'font-icon-picker-base', STICKY_LIST_ASSETS . 'vendor/font-awesome/css/fonticonpicker.base-theme.react.css', array(), STICKY_LIST_VERSION );
		wp_enqueue_style( 'font-icon-picker-material', STICKY_LIST_ASSETS . 'vendor/font-awesome/css/fonticonpicker.material-theme.react.css', array(), STICKY_LIST_VERSION );
	}

	/**
	 * Common Assets
	 *
	 * Enqueue Frontend Styles and Scripts
	 */
	public function common_assets() {

		$panel_settings = Helper::get_option( 'sticky_list_panel_settings' );

		$should_enqueue_fa = $panel_settings['enqueue_fa'] ? true : false;

		// Only load Font Awesome if the user wants it.
		if ( $should_enqueue_fa ) {
			wp_enqueue_style( 'font-awesome', STICKY_LIST_ASSETS . 'vendor/font-awesome/css/all.min.css', '', STICKY_LIST_VERSION );
		}

		$frontend_css_version = filemtime( STICKY_LIST_DIR_PATH . 'assets/css/frontend.css' );
		$frontend_js_version  = filemtime( STICKY_LIST_DIR_PATH . 'assets/js/frontend.js' );

		wp_enqueue_style( 'sticky-list-frontend', STICKY_LIST_ASSETS . 'css/frontend.css', '', $frontend_css_version );
		wp_enqueue_script( 'sticky-list-frontend', STICKY_LIST_ASSETS . 'js/frontend.js', array( 'jquery' ), $frontend_js_version, true );
	}

	/**
	 * Frontend Assets
	 *
	 * Enqueue Frontend Styles and Scripts
	 */
	public function frontend_assets() {
		$this->common_assets();
	}
}
