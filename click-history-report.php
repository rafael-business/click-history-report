<?php
/**
 * Click History Report
 *
 * @package   Click_History_Report
 * @author    Rafael dos Santos <contato@rafael.work>
 * @license   GPL-2.0+
 * @link      https://github.com/rafael-business/click-history-report
 * @copyright 2023 Rafael dos Santos, Rafael Business ME
 *
 * @wordpress-plugin
 * Plugin Name:       Click History Report
 * Plugin URI:        https://github.com/rafael-business/click-history-report
 * Description:       Adds a command to WP-CLI responsible for creating a report with the history of clicks on the Click Counter Button plugin button. Example: <code>wp cc report 10 --order=DESC</code> (show the last 10 records).
 * Version:           1.0.0
 * Author:            Rafael dos Santos
 * Author URI:        https://rafael.work
 * Text Domain:       click-history-report
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/rafael-business/click-history-report
 * GitHub Branch:     master
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Click_History_Report
{
	/**
	 * Static property to hold our singleton instance
	 *
	 */
	static $instance = false;

	/**
	 * This is our constructor
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'textdomain' ) );
	}

	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * retuns it.
	 *
	 * @return Click_History_Report
	 */
	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	/**
	 * load textdomain
	 *
	 * @return void
	 */
	public function textdomain() {
		load_plugin_textdomain( 'click-history-report', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

$Click_History_Report = Click_History_Report::getInstance();

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once plugin_dir_path( __FILE__ ) . 'class-chr-cli-cmd.php';
}