<?php
/**
 * Plugin Name:       Sticky List - Customizable Interactive Slide Panels for Websites
 * Plugin URI:        https://ultradevs.com/products/wp-plugin/sticky-list
 * Description:       Sticky List lets you add customizable slide panels to your website.
 * Version: 1.0.0
 * Author:            ultradevs
 * Author URI:        https://ultradevs.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sticky-list
 * Domain Path:       /languages
 *
 * @package           Sticky List
 */

// If this file is called directly, abort!
defined( 'ABSPATH' ) || exit( 'bYe bYe!' );

// Constant.
define( 'STICKY_LIST_VERSION', '1.0.0' );
define( 'STICKY_LIST_NAME', __( 'Sticky List', 'sticky-list' ) );
define( 'STICKY_LIST_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'STICKY_LIST_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'STICKY_LIST_ASSETS', STICKY_LIST_DIR_URL . 'assets/' );
define( 'STICKY_LIST_MENU_SLUG', 'sticky-list' );

/**
 * Require Composer Autoload
 */
require_once STICKY_LIST_DIR_PATH . 'vendor/autoload.php';


if ( ! function_exists( 'sl_fs' ) ) {
	// Create a helper function for easy SDK access.
	function sl_fs() {
		global $sl_fs;

		if ( ! isset( $sl_fs ) ) {
			// Include Freemius SDK.
			require_once dirname(__FILE__) . '/freemius/start.php';

			$sl_fs = fs_dynamic_init(
				array(
					'id'                  => '16481',
					'slug'                => 'sticky-list',
					'premium_slug'        => 'sticky-list-pro',
					'type'                => 'plugin',
					'public_key'          => 'pk_f73eeb8ad6f0da7d38066d65cca90',
					'is_premium'          => false,
					'premium_suffix'      => 'Pro',
					// If your plugin is a serviceware, set this option to false.
					'has_premium_version' => true,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'menu'                => array(
						'slug'       => 'sticky-list',
						'first-path' => 'admin.php?page=sticky-list',
					),
				)
			);
		}

		return $sl_fs;
	}

	// Init Freemius.
	sl_fs();
	// Signal that SDK was initiated.
	do_action( 'sl_fs_loaded' );
}

/**
 * Sticky List class
 */
final class StickyList {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'init' ) );

		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'init', array( $this, 'load_text_domain' ) );

		do_action( 'sticky_list_loaded' );
	}

	/**
	 * Begin execution of the plugin
	 *
	 * @return \StickyList
	 */
	public static function run() {
		/**
		 * Instance
		 *
		 * @var boolean
		 */
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Plugin Init
	 */
	public function init() {

		// Assets Manager Class.
		$assets_manager = new ultraDevs\SL\Assets_Manager();

		// Activate.
		$activate = new ultraDevs\SL\Activate();

		// Install Service.
		// $install = (new ultraDevs\SL\Install\Install_Service())::get_instance();

		// Dashboard.
		$dashboard = new ultraDevs\SL\Admin\Dashboard();

		add_action( 'admin_init', array( $dashboard, 'register_setting_options' ) );

		add_action( 'rest_api_init', array( $dashboard, 'register_setting_options' ) );

		if ( is_admin() ) {

			// Activation_Redirect.
			add_action( 'admin_init', array( $activate, 'activation_redirect' ) );

			// Dashboard.
			$dashboard->register();

			// Plugin Action Links.
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );

			$review = new ultraDevs\SL\Review();

			// Review Notice.
			$review->register();

		} else {
			// View.
			new \ultraDevs\SL\Display();

			// Frontend Assets.
			add_action( 'wp_enqueue_scripts', array( $assets_manager, 'frontend_assets' ) );
		}
	}

	/**
	 * The code that runs during plugin activation.
	 */
	/**
	 * Plugin Activation.
	 *
	 * @return void
	 */
	public function activate() {
		$activate = new ultraDevs\SL\Activate();
		$activate->run();
	}

	/**
	 * Loads a plugin’s translated strings.
	 *
	 * @return void
	 */
	public function load_text_domain() {
		load_plugin_textdomain( 'sticky-list', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Plugin Action Links
	 *
	 * @param array $links Links.
	 * @return array
	 */
	public function plugin_action_links( $links ) {

		$links[] = '<a href="' . admin_url( 'admin.php?page=' . STICKY_LIST_MENU_SLUG ) . '">' . __( 'Settings', 'sticky-list' ) . '</a>';

		return $links;
	}
}
/**
 * Check if sticky_list doesn't exist
 */
if ( ! function_exists( 'sticky_list' ) ) {
	/**
	 * Load Sticky List
	 *
	 * @return StickyList
	 */
	function sticky_list() {
		return StickyList::run();
	}
}
sticky_list();
