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
use SilverWpAddons\PostType\News;
use SilverWpAddons\PostType\Publications;
use SilverWpAddons\PostType\Research;
use SilverWpAddons\PostType\Resources;
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

	        $events = News::getInstance();
	        $events->registerMetaBox( MetaBox\News::getInstance() );
	        $events->registerTaxonomy( Taxonomy\News::getInstance() );

	        $resources = Resources::getInstance();
	        $resources->registerMetaBox( MetaBox\Resources::getInstance() );

	        $research = Research::getInstance();
	        $research->registerMetaBox( MetaBox\Research::getInstance() );

	        $publications = Publications::getInstance();
	        $publications->registerMetaBox( MetaBox\Publications::getInstance() );
	        $publications->registerTaxonomy( Taxonomy\Publications::getInstance() );

	        $authors = Authors::getInstance();
	        $authors->registerMetaBox( MetaBox\Authors::getInstance() );

	        $team = Team::getInstance();
	        $team->registerMetaBox( MetaBox\Team::getInstance() );

	        //posts relationship
	        #events_to_research
	        $events_to_research = $events->addRelationship( 'events_to_research', $research );
	        $events_to_research->admin_box = array(
		        'show' => 'from'
	        );
	        $events_to_research->title = Translate::translate( 'Project' );
	        $events_to_research->to_labels = array(
		        'create'        => Translate::translate( 'Select Project' ),
		        'singular_name' => Translate::translate( 'Project' ),
		        'search_items'  => Translate::translate( 'Search projects' ),
		        'not_found'     => Translate::translate( 'No projects found.' ),
	        );
			#endevents_to_research
	        #s_to_research
	        //nave menu hook
            NavMenu::getInstance();

        } catch ( Exception $ex ) {
            echo $ex->catchException();
        }
    }
} );
