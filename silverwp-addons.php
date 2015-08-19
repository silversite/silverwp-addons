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
 * @link              https://github.com/silversite/silverwp-addons
 * @since             1.0
 * @package           SilverWPAddons
 *
 * @wordpress-plugin
 * Plugin Name:       SilverWP Add-ons
 * Description:       This is necessary for themes based on SilverWp platform
 *                    In this plugin are defined all: CPT, CMB, CT
 * Version:           1.0
 * Author:            Michal Kalkowski <michal at silversite.pl>
 * Author URI:        http://silversite.pl/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       silverwp-addons
 * Domain Path:       /languages
 */
use SilverWp\Exception;
use SilverWp\Helper\NavMenu;
use SilverWp\Helper\Option;
use SilverWp\Translate;
use SilverWpAddons\PostType\Authors;
use SilverWpAddons\PostType\Events;
use SilverWpAddons\PostType\Publications;
use SilverWpAddons\PostType\Research;
use SilverWpAddons\PostType\Sources;
use SilverWpAddons\PostType\Team;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require_once 'vendor/autoload.php';
add_action( 'plugins_loaded', function () {
    if ( class_exists( 'SilverWp\SilverWp' ) ) {

        try {
            Translate::$language_path   = plugin_dir_path( __FILE__ ) . 'languages';
            Translate::$text_domain     = 'silverwp';
	        Translate::init();

	        $events = Events::getInstance();
	        $events->registerMetaBox( MetaBox\Events::getInstance() );
	        $events->registerTaxonomy( Taxonomy\Events::getInstance() );

	        $sources = Sources::getInstance();
	        $sources->registerMetaBox( MetaBox\Sources::getInstance() );

	        $research = Research::getInstance();
	        $research->registerMetaBox( MetaBox\Research::getInstance() );

	        $publications = Publications::getInstance();
	        $publications->registerMetaBox( MetaBox\Publications::getInstance() );
	        $publications->registerTaxonomy( Taxonomy\Publications::getInstance() );

	        $authors = Authors::getInstance();
	        $authors->registerMetaBox( MetaBox\Authors::getInstance() );

	        $team = Team::getInstance();
	        $team->registerMetaBox( MetaBox\Team::getInstance() );

	        //nave menu hook
            NavMenu::getInstance();

        } catch ( Exception $ex ) {
            echo $ex->catchException();
        }
    }
} );
