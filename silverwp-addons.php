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
use SilverWp\SilverWp;
use SilverWp\Translate;
use SilverWp\Wpml\Wpml;
use SilverWpAddons\MetaBox;
use SilverWpAddons\PostType;
use SilverWpAddons\Taxonomy;

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

	        MetaBox\Page::getInstance();
	        MetaBox\Posts::getInstance();

	        $portfolio = PostType\Portfolio::getInstance();
//	        $portfolio->registerTaxonomy( Taxonomy\Portfolio::getInstance() );
	        $portfolio->addTemplates( 'template-portfolio.php' );
	        $portfolio->registerMetaBox( MetaBox\Portfolio::getInstance() );
	        //todo move to PostTypeAbstract
	        add_post_type_support( $portfolio->getName(), array( 'excerpt' ) );

	        $clients = PostType\Clients::getInstance();
	        $clients->registerMetaBox( MetaBox\Clients::getInstance() );

	        #widgets
	        //new Widget\Social();
	        #endwidgets
	    } catch ( Exception $ex ) {
            echo $ex->catchException();
        }
    }
} );
