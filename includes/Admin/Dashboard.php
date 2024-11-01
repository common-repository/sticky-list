<?php
/**
 * Dashboard
 *
 * @package StickyList
 * @since 1.0.0
 */

namespace ultraDevs\SL\Admin;

use ultraDevs\SL\Helper;
use ultraDevs\SL\Assets_Manager;

/**
 * Dashboard Class
 *
 * @package StickyList
 * @since 1.0.0
 */
class Dashboard {
	/**
	 * Menu
	 *
	 * @var string
	 */
	public static $menu = '';

	/**
	 * Menu Icon
	 *
	 * @var string
	 */
	public static $icon = STICKY_LIST_ASSETS . 'images/sl.svg';

	/**
	 * Register
	 */
	public function register() {
		add_action( 'admin_menu', array( __CLASS__, 'register_menu' ) );

		if ( is_admin() && isset( $_GET[ 'page' ] ) && STICKY_LIST_MENU_SLUG === wp_unslash( $_GET['page'] ) ) { // phpcs:ignore
			add_action( 'in_admin_header', array( $this, 'remove_notices' ) );
		}
	}


	/**
	 * Register Admin Menu
	 */
	public static function register_menu() {
		self::$menu = add_menu_page( __( 'Dashboard - Sticky List', 'sticky-list' ), __( 'Sticky List', 'sticky-list' ), 'manage_options', STICKY_LIST_MENU_SLUG, array( __CLASS__, 'view_main' ), Helper::get_icon(), 56 );

		// Assets Manager Class.
		$assets_manager = new Assets_Manager();

		add_action( 'admin_print_scripts-' . self::$menu, array( $assets_manager, 'admin_assets' ) );
	}

	/**
	 * Main View
	 */
	public static function view_main() {
		echo '<div id="sticky-list-app"></div>';
	}

	/**
	 * Register Settings.
	 */
	public function register_setting_options() {

		/** Panel */
		register_setting(
			'sticky-list-settings',
			'sticky_list_panel_settings',
			array(
				'type'         => 'object',
				'show_in_rest' => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'width'        => array(
								'type' => 'integer',
							),
							'position'     => array(
								'type' => 'string',
							),
							'enqueue_fa'   => array(
								'type' => 'boolean',
							),
							'opener_media' => array(
								'type'       => 'object',
								'properties' => array(
									'type'  => array(
										'type' => 'string',
									),
									'icon'  => array(
										'type' => 'string',
									),
									'image' => array(
										'type' => 'string',
									),
								),
							),
						),
					),
				),
				'default'      => array(
					'width'        => 300,
					'position'     => 'left',
					'enqueue_fa'   => true,
					'opener_media' => array(
						'type'  => 'icon',
						'icon'  => 'fas fa-sort-alpha-down',
						'image' => '',
					),
				),
			)
		);

		// register_setting(
		// 'sticky-list-settings',
		// 'sticky_list_panel_location',
		// array(
		// 'type'         => 'array',
		// 'show_in_rest' => array(
		// 'schema' => array(
		// 'type'  => 'array',
		// 'items' => array(
		// 'type' => 'string',
		// ),
		// ),
		// ),
		// 'default'      => array( 'all' ),
		// )
		// );

		/** Content */
		register_setting(
			'sticky-list-settings',
			'sticky_list_panel_content',
			array(
				'type'         => 'object',
				'show_in_rest' => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'title'   => array(
								'type' => 'string',
							),
							'content' => array(
								'type' => 'string',
							),
							'html'    => array(
								'type' => 'string',
							),
						),
					),
				),
				'default'      => array(
					'title'   => __( 'Sticky List', 'sticky-list' ),
					'content' => "## Header\n[ - ultraDevs](https://www.ultradevs.com)\n[ - ultraDevs](https://www.ultradevs.com)",
					'html'    => "<strong>ultraDevs</strong> <a href='https://ultradevs.com'>ultraDevs</a>",
				),
			)
		);

		/** Styles */
		register_setting(
			'sticky-list-settings',
			'sticky_list_panel_styles',
			array(
				'type'         => 'object',
				'show_in_rest' => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'opener_style'          => array(
								'type' => 'string',
							),
							'opener_color'          => array(
								'type' => 'string',
							),
							'opener_bg_color'       => array(
								'type' => 'string',
							),
							'opener_hover_color'    => array(
								'type' => 'string',
							),
							'opener_hover_bg_color' => array(
								'type' => 'string',
							),
							'opener_size'           => array(
								'type' => 'integer',
							),
							'bg_color'              => array(
								'type' => 'string',
							),
							'title_bg_color'        => array(
								'type' => 'string',
							),
							'title_color'           => array(
								'type' => 'string',
							),
							'typo'                  => array(
								'type'       => 'object',
								'properties' => array(
									'font_family' => array(
										'type' => 'string',
									),
									'font_size'   => array(
										'type' => 'integer',
									),
								),
							),
							'title_typo'            => array(
								'type'       => 'object',
								'properties' => array(
									'font_family' => array(
										'type' => 'string',
									),
									'font_size'   => array(
										'type' => 'integer',
									),
									'font_weight' => array(
										'type' => 'string',
									),
									'font_style'  => array(
										'type' => 'string',
									),
								),
							),
						),
					),
				),
				'default'      => array(
					'opener_style'          => 'style-box',
					'opener_color'          => '#fff',
					'opener_bg_color'       => '#f30d55',
					'opener_hover_color'    => '#fff',
					'opener_hover_bg_color' => '#5821E5',
					'opener_size'           => 25,

					'bg_color'              => '#fff',
					'title_bg_color'        => '#f30d55',
					'title_color'           => '#fff',

					'typo'                  => array(
						'font_family' => 'Roboto',
						'font_size'   => 16,
					),
					'title_typo'            => array(
						'font_family' => 'Roboto',
						'font_size'   => 18,
						'font_weight' => 'bold',
						'font_style'  => 'normal',
					),
				),
			)
		);

		/** Animation */
		register_setting(
			'sticky-list-settings',
			'sticky_list_anim_speed',
			array(
				'type'         => 'string',
				'show_in_rest' => true,
				'default'      => 300,
			)
		);
		register_setting(
			'sticky-list-settings',
			'sticky_list_anim_easing_effect',
			array(
				'type'         => 'string',
				'show_in_rest' => true,
				'default'      => 'swing',
			)
		);

		// Content Links & Heading Color.
		register_setting(
			'sticky-list-settings',
			'sticky_list_content_colors',
			array(
				'type'         => 'object',
				'show_in_rest' => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'link_color'       => array(
								'type' => 'string',
							),
							'hover_link_color' => array(
								'type' => 'string',
							),
							'heading_color'    => array(
								'type' => 'string',
							),
						),
					),
				),
				'default'      => array(
					'link_color'       => '#111',
					'hover_link_color' => '#333',
					'heading_color'    => '#111',
				),
			)
		);
	}

	/**
	 * Remove All Notices.
	 *
	 * @return void
	 */
	public function remove_notices() {
		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'all_admin_notices' );
	}
}
