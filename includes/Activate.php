<?php
/**
 * Activate
 *
 * @package StickyList
 * @since 1.0.0
 */

namespace ultraDevs\SL;

use ultraDevs\SL\Helper;

/**
 * Activate Class
 *
 * @package StickyList
 * @since 1.0.0
 */
class Activate {
	/**
	 * The code that runs during plugin activation.
	 *
	 * @return void
	 */
	public function run() {
		flush_rewrite_rules();
		$this->plugin_data();
		$this->settings_data();
	}

	/**
	 * Setting Data
	 *
	 * @return void
	 */
	public function settings_data() {
		$panel_settings = Helper::get_option( 'sticky_list_panel_settings' );
		$panel_content  = Helper::get_option( 'sticky_list_panel_content' );
		$panel_styles   = Helper::get_option( 'sticky_list_panel_styles' );
		$content_colors = Helper::get_option( 'sticky_list_content_colors' );

		if ( ! $panel_settings ) {
			$panel_settings_data = array(
				'width'        => 300,
				'position'     => 'left',
				'enqueue_fa'   => true,
				'opener_media' => array(
					'type'  => 'icon',
					'icon'  => 'fas fa-sort-alpha-down',
					'image' => '',
				),
			);
			Helper::update_option( 'sticky_list_panel_settings', $panel_settings_data, 'no' );
		}
		if ( ! $panel_content ) {
			$panel_content_data = array(
				'title'   => __( 'Sticky List', 'sticky-list' ),
				'content' => "## Header\n[ - ultraDevs](https://www.ultradevs.com)\n[ - ultraDevs](https://www.ultradevs.com)",
				'html'    => "<strong>ultraDevs</strong> <br> <a href='https://ultradevs.com'>ultraDevs</a>",
			);
			Helper::update_option( 'sticky_list_panel_content', $panel_content_data, 'no' );
		}
		if ( ! $panel_styles ) {
			$panel_styles_data = array(
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
			);
			Helper::update_option( 'sticky_list_panel_styles', $panel_styles_data, 'no' );
		}

		if ( ! $content_colors ) {
			$content_colors_data = array(
				'link_color'       => '#111',
				'hover_link_color' => '#333',
				'heading_color'    => '#111',
			);
			Helper::update_option( 'sticky_list_content_colors', $content_colors_data, 'no' );
		}
	}

	/**
	 * Save Plugin's Data
	 */
	public function plugin_data() {
		Helper::update_option( 'sticky_list_version', STICKY_LIST_VERSION, 'no' );

		$installed_time = Helper::get_option( 'sticky_list_installed_datetime', false );
		if ( ! $installed_time ) {
			Helper::update_option( 'sticky_list_installed_datetime', current_time( 'timestamp' ), 'no' ); // phpcs:ignore
		}
	}

	/**
	 * Activation Redirect
	 */
	public function activation_redirect() {

		if ( get_option( 'sticky_list_do_activation_redirect', false ) ) {

			delete_option( 'sticky_list_do_activation_redirect' );
			wp_safe_redirect( admin_url( 'admin.php?page=' . STICKY_LIST_MENU_SLUG ) );
			exit();
		}
	}
}
