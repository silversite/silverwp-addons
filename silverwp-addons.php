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

	        $news = News::getInstance();
	        $news->registerMetaBox( MetaBox\News::getInstance() );
	        $news->registerTaxonomy( Taxonomy\News::getInstance() );
	        $news->addTemplates(
		        array(
			        'single-news.php'
		        )
	        );
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
	        #news_to_research
	        $news_to_research = $news->addRelationship( 'news_to_research', $research );
	        $news_to_research->admin_box = array(
		        'show' => 'from'
	        );
	        $news_to_research->title = Translate::translate( 'Project' );
	        $news_to_research->to_labels = array(
		        'create'        => Translate::translate( 'Select Project' ),
		        'singular_name' => Translate::translate( 'Project' ),
		        'search_items'  => Translate::translate( 'Search projects' ),
		        'not_found'     => Translate::translate( 'No projects found.' ),
	        );
	        //$news_to_research->cardinality = 'one-to-one';
			#end news_to_research

	        #resources_to_research
	        $resources_to_research = $resources->addRelationship( 'resources_to_research', $research );
	        $resources_to_research->admin_box = array(
		        'show' => 'from'
	        );
	        $resources_to_research->title = Translate::translate( 'Project' );
	        $resources_to_research->to_labels = array(
		        'create'        => Translate::translate( 'Select Project' ),
		        'singular_name' => Translate::translate( 'Project' ),
		        'search_items'  => Translate::translate( 'Search projects' ),
		        'not_found'     => Translate::translate( 'No projects found.' ),
	        );
	        $resources_to_research->cardinality = 'one-to-one';
	        #endresources_to_research

	        #resources_to_publication
	        $resources_to_publication = $resources->addRelationship( 'resources_to_publications', $publications );
	        $resources_to_publication->admin_box = array(
		        'show' => 'from'
	        );
	        $resources_to_publication->title = Translate::translate( 'Publication' );
	        $resources_to_publication->to_labels = array(
		        'create'        => Translate::translate( 'Select Publication' ),
		        'singular_name' => Translate::translate( 'Publication' ),
		        'search_items'  => Translate::translate( 'Search publications' ),
		        'not_found'     => Translate::translate( 'No publication found.' ),
	        );
	        #endresources_to_publication

	        #research_to_publications
	        $research_to_publications = $research->addRelationship( 'research_to_publications', $publications );
	        $research_to_publications->title = array(
		        'from' => Translate::translate( 'Publications' ),
		        'to'   => Translate::translate( 'Researches' ),
	        );
	        $research_to_publications->to_labels = array(
		        'create'        => Translate::translate( 'Select Publication' ),
		        'singular_name' => Translate::translate( 'Publication' ),
		        'search_items'  => Translate::translate( 'Search Publication' ),
		        'not_found'     => Translate::translate( 'No Publication found.' ),
	        );
	        $research_to_publications->from_labels = array(
		        'create'        => Translate::translate( 'Select Research' ),
		        'singular_name' => Translate::translate( 'Research' ),
		        'search_items'  => Translate::translate( 'Search Research' ),
		        'not_found'     => Translate::translate( 'No Research found.' ),
	        );
	        #endresearch_to_publications

			#authors_to_publications
	        $authors_to_publications = $publications->addRelationship( 'authors_to_publications', $authors );
	        $authors_to_publications->title = array(
		        'from' => Translate::translate( 'Authors' ),
	        );
	        $authors_to_publications->admin_box = array(
		        'show' => 'from'
	        );
	        $authors_to_publications->to_labels = array(
		        'create'        => Translate::translate( 'Select Author' ),
		        'singular_name' => Translate::translate( 'Author' ),
		        'search_items'  => Translate::translate( 'Search Author' ),
		        'not_found'     => Translate::translate( 'No Author found.' ),
	        );
	        #endauthors_to_publications

	        //nave menu hook
            NavMenu::getInstance();

        } catch ( Exception $ex ) {
            echo $ex->catchException();
        }
    }
} );
