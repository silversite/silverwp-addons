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
use SilverWp\Exception;
use SilverWp\Helper\Option;
use SilverWp\Translate;
use SilverWp\SilverWp;
use SilverWp\Ajax\Tweetie;
use SilverWp\Wpml\Wpml;
use SilverWpAddons\Ajax\MegaMenu;
use SilverWpAddons\Ajax\PostLike;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
define('SILVERWP_THEME_OPTIONS_DEV', false);

require_once 'vendor/autoload.php';
add_action( 'plugins_loaded', function () {
    if ( class_exists( 'SilverWp\SilverWp' ) ) {
        try {
	        Translate::$language_path = plugin_dir_url( __FILE__ ) . 'languages/';
            Translate::$text_domain = 'silverwp-addons';
	        Translate::init();

	        if ( \class_exists( '\SilverWpAddons\MetaBox\Blog' ) ) {
                MetaBox\Blog::getInstance();
            }

            if ( \class_exists( '\SilverWpAddons\MetaBox\Page' ) ) {
                MetaBox\Page::getInstance();
            }

            //nave menu hook
            NavMenu::getInstance();

            //register sidebars
            Sidebar\ToggleNav::getInstance();

            if ( function_exists( 'vc_set_as_theme' ) ) {
                ShortCode\Setup::getInstance();
            }

	        SilverWp::getInstance()->addWidget( 'SilverWpAddons\Widget\RecentPosts' );
	        SilverWp::getInstance()->addWidget( 'SilverWpAddons\Widget\Social' );
	        //get tweets from tweeter
            if ( Option::get_theme_option( 'use_twitter_plugin' ) === '1' ) {
                Tweetie::getInstance();
	            SilverWp::getInstance()->addWidget( 'SilverWpAddons\Widget\TwitterRecentPosts' );
            }

	        PostLike::getInstance();
	        MegaMenu::getInstance();
	        if ( function_exists( 'icl_object_id' ) ) {
				Wpml::getInstance();
			}


        } catch ( Exception $ex ) {
            echo $ex->catchException();
        }
    }
} );
