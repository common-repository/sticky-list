<?php
/**
 * Install Service
 *
 * @package StickyList
 */

namespace ultraDevs\SL\Install;

use ultraDevs\SL\Install\Updates\Update_1_0_1;

class Install_Service {

	/**
	 * Instance
	 *
	 * @var \ultraDevs\SL\Install\Install_Service $instance
	 */
	private static $instance;

	/**
	 * Installs Versions
	 */
	private $installs;

	public function __construct() {
		$this->installs = array(
			new Update_1_0_1(),
		);

		add_action( 'init', array( $this, 'run_installs' ) );
	}

	/**
	 * Get Instance
	 *
	 * @return \ultraDevs\SL\Install\Install_Service
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Install_Service();
		}

		return self::$instance;
	}

	/**
	 * Run Installs
	 *
	 * @return void
	 */
	public function run_installs() {
		$installed_version = get_option( 'sticky_list_version' );

		if ( ! $installed_version ) {
			$installed_version = '1.0.0';
		}

		$installs = $this->get_installs();

		if ( empty( $installs ) ) {
			return;
		}

		foreach ( $installs as $install ) {
			if ( version_compare( $installed_version, $install->get_version(), '<' ) ) {
				$install->run();
			}
		}

		update_option( 'sticky_list_version', STICKY_LIST_VERSION );
	}

	/**
	 * Get Installs
	 *
	 * @return array
	 */
	public function get_installs() {
		return $this->installs;
	}
}
