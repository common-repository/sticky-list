<?php
/**
 * Version 1.0.1
 *
 * @package StickyList
 */

namespace ultraDevs\SL\Install\Updates;

use ultraDevs\SL\Install\Install;

class Update_1_0_1 extends Install {

	/**
	 * Version
	 *
	 * @var string $version Version
	 */
	public static $version = '1.0.1';

	/**
	 * Run
	 *
	 * @return void
	 */
	public function run() {
		$this->settings_data();
	}

	/**
	 * Setting Data
	 *
	 * @return void
	 */
	public function settings_data() {
		// Update data if needed.
	}
}
