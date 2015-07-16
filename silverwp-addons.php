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
 * Version:           0.1
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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require_once 'vendor/autoload.php';
add_action( 'plugins_loaded', function () {
    if ( class_exists( 'SilverWp\SilverWp' ) ) {
    
        try {
            Translate::$language_path = plugin_dir_url( __FILE__ ) . 'languages/';
            Translate::$text_domain = 'silverwp-addons';

            if ( \class_exists( '\SilverWpAddons\PostType\Portfolio' ) ) {
                $Portfolio = PostType\Portfolio::getInstance();
                $Portfolio->registerMetaBox( MetaBox\Portfolio::getInstance() );
                $Portfolio->registerTaxonomy( Taxonomy\Portfolio::getInstance() );
                $Portfolio->addTemplates(
                    array(
                        'list-grid-classic-portfolio.php',
                        'list-grid-masonry-portfolio.php',
                        'list-grid-merge-portfolio.php',
                        'list-grid-text-portfolio.php',
                    )
                );
                Ajax\Portfolio::getInstance();
            }
            
            if ( \class_exists( '\SilverWpAddons\MetaBox\Blog' ) ) {
                MetaBox\Blog::getInstance();
            }

            if ( \class_exists( '\SilverWpAddons\MetaBox\Page' ) ) {
                MetaBox\Page::getInstance();
            }

            //nave menu hook
            NavMenu::getInstance();

            //register sidebars
            Sidebar\Blog::getInstance();
            Sidebar\Portfolio::getInstance();
            Sidebar\Contact::getInstance();
            Sidebar\Primary::getInstance();
            Sidebar\Footer::getInstance();

            if ( function_exists( 'vc_set_as_theme' ) ) {
                ShortCode\Setup::getInstance();
            }

            //post like
            Ajax\PostLike::getInstance();
            //get tweets from tweeter
            if ( Option::get_theme_option( 'use_twitter_plugin' ) === '1' ) {
                Ajax\Tweetie::getInstance();
            }
        } catch ( Exception $ex ) {
            echo $ex->catchException();
        }
    }
} );
