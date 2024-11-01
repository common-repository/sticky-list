<?php
/**
 * Install
 *
 * @package StickyList
 */
namespace ultraDevs\SL\Install;

abstract class Install {

	/**
	 * Version
	 *
	 * @var string $version Version
	 */
	public static $version = '0.0.0';

	/**
	 * Run Install
	 *
	 * @return void
	 */
	abstract public function run();

	/**
	 * Get Version
	 *
	 * @return string
	 */
	public function get_version() {
		return static::$version;
	}
}
