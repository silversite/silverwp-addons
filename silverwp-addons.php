<?php
namespace SilverWpAddons;
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/padalec/silverwp-addons
 * @since             0.1
 * @package           SilverWPAddons
 *
 * @wordpress-plugin
 * Plugin Name:       SilverWP Add-ons
 * Description:       This is necessary for themes based on SilverWp platform
 *                    In this plugin are defined all: CPT, CMB, CT
 * Version:           0.5
 * Author:            Michal Kalkowski <michal at silversite.pl>
 * Author URI:        http://silversite.pl/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       silverwp-addons
 * Domain Path:       /languages
 */
use Currency\Model\Mapper\CurrentDayRate;
use Currency\Model\Service\CurrentDayRateMapperFactory;
use SilverWp\Debug;
use SilverWp\Exception;
use SilverWp\FileSystem;
use SilverWp\Translate;
use SilverWpAddons\Ajax\SelectDay;
use SilverWpAddons\PostType\Currency;
use SilverZF2\Common\Application;
use SilverZF2\Common\Traits\SingletonAwareTrait;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require_once 'vendor/autoload.php';
add_action(
	'plugins_loaded',
	function () {
		if ( class_exists( 'SilverWp\SilverWp' ) ) {

	        try {
				load_plugin_textdomain( 'silverwp_addons', false, plugin_dir_path( __FILE__ ) . 'languages/' );

		        FileSystem::getInstance()->addDirectory( 'plugin_config_dir', plugin_dir_path( __FILE__ ) . 'config/' );

		        $currency = Currency::getInstance();
		        $currency->registerMetaBox( MetaBox\Currency::getInstance() );
		        $currency->registerTaxonomy( Taxonomy\Currency::getInstance() );

		        SelectDay::getInstance();

	        } catch ( Exception $ex ) {
	            echo $ex->catchException();
	        }
	    }
	},
	12
);
