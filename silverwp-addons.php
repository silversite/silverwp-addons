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

	        $news = PostType\News::getInstance();
	        $news->registerTaxonomy( Taxonomy\News::getInstance() );
	        $news->registerMetaBox( MetaBox\News::getInstance() );
	        $news->addTemplates( 'template-news.php' );
	        //todo move to PostTypeAbstract
	        add_post_type_support( $news->getName(), array( 'excerpt' ) );

	        $events = PostType\Events::getInstance();
	        $events->registerTaxonomy( Taxonomy\Events::getInstance() );
	        $events->registerMetaBox( MetaBox\Events::getInstance() );
	        $events->addTemplates( 'template-events.php' );
	        add_post_type_support( $events->getName(), array( 'excerpt' ) );

	        $research = PostType\Research::getInstance();
			$research->registerMetaBox( MetaBox\Research::getInstance() );
	        $research->registerTaxonomy( Taxonomy\Research::getInstance() );
	        $research->addTemplates( 'template-research.php' );
	        add_post_type_support( $research->getName(), array( 'excerpt' ) );

			$resources = PostType\Resources::getInstance();
	        $resources->registerMetaBox( MetaBox\Resources::getInstance() );
	        $resources->registerTaxonomy( Taxonomy\Resources::getInstance() );
	        $resources->addTemplates( 'template-resources.php' );
	        add_post_type_support( $resources->getName(), array( 'excerpt' ) );

	        $publications = PostType\Publications::getInstance();
			$publications->registerMetaBox( MetaBox\Publications::getInstance() );
	        $publications->registerTaxonomy( Taxonomy\Publications::getInstance() );
	        $publications->addTemplates( 'template-publication.php' );
//	        add_post_type_support( $publications->getName(), array( 'excerpt' ) );

	        $comments = PostType\Comments::getInstance();
	        $comments->addTemplates( 'template-comments.php' );
	        add_post_type_support( $comments->getName(), array( 'excerpt' ) );

			$authors = PostType\Authors::getInstance();
			$authors->registerMetaBox( MetaBox\Authors::getInstance() );

			$team = PostType\Team::getInstance();
			$team->registerMetaBox( MetaBox\Team::getInstance() );
	        $team->addTemplates( 'template-team.php' );
	        //posts relationship
	        #team_to_authors
	        $team_to_authors = $team->addRelationship( 'team_to_authors', $authors );
	        $team_to_authors->title = array(
		        'from' => Translate::translate( 'Authors' ),
		        'to'   => Translate::translate( 'Persons from IBS' ),
	        ) ;
	        $team_to_authors->from_labels = array(
		        'create'        => Translate::translate( 'Select Person' ),
		        'singular_name' => Translate::translate( 'Person' ),
		        'search_items'  => Translate::translate( 'Search persons' ),
		        'not_found'     => Translate::translate( 'No person found.' ),
	        );

	        $team_to_authors->to_labels = array(
		        'create'        => Translate::translate( 'Select Author' ),
		        'singular_name' => Translate::translate( 'Author' ),
		        'search_items'  => Translate::translate( 'Search authors' ),
		        'not_found'     => Translate::translate( 'No author found.' ),
	        );

	        $team_to_authors->cardinality = 'one-to-one';
	        #end team_to_authors

	        #news_to_research
	        $news_to_research = $news->addRelationship( 'news_to_research', $research );
	        $news_to_research->admin_box = array(
		        'show' => 'from'
	        );
	        $news_to_research->title = Translate::translate( 'Researches' );
	        $news_to_research->to_labels = array(
		        'create'        => Translate::translate( 'Select Research' ),
		        'singular_name' => Translate::translate( 'Research' ),
		        'search_items'  => Translate::translate( 'Search researches' ),
		        'not_found'     => Translate::translate( 'No researches found.' ),
	        );

	        //$news_to_research->cardinality = 'one-to-one';

	        #news_to_resources
	        $news_to_resources= $news->addRelationship( 'news_to_resources', $resources );
	        $news_to_resources->admin_box = array(
		        'show' => 'from'
	        );
	        $news_to_resources->title = Translate::translate( 'Resources' );
	        $news_to_resources->to_labels = array(
		        'create'        => Translate::translate( 'Select Resource' ),
		        'singular_name' => Translate::translate( 'Resource' ),
		        'search_items'  => Translate::translate( 'Search resource' ),
		        'not_found'     => Translate::translate( 'No resources found.' ),
	        );
	        #end team_to_resources

	        #team_to_comments
	        $team_to_comments = $comments->addRelationship( 'team_to_comments', $team );
	        $team_to_comments->admin_box = array(
		        'show' => 'from'
	        );
	        $team_to_comments->title = Translate::translate( 'Persons from IBS' );
	        $team_to_comments->to_labels = array(
		        'create'        => Translate::translate( 'Select Person' ),
		        'singular_name' => Translate::translate( 'Person' ),
		        'search_items'  => Translate::translate( 'Search persons' ),
		        'not_found'     => Translate::translate( 'No person found.' ),
	        );
			#team_to_comments

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
//			$resources_to_publication->admin_box = array(
//				'show' => 'from'
//			);
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
			#resources_to_publications
	        $resources_to_publications = $publications->addRelationship( 'resources_to_publications', $resources );
	        $resources_to_publications->title = array(
		        'from' => Translate::translate( 'Resources' ),
	        );
	        $resources_to_publications->admin_box = array(
		        'show' => 'from'
	        );
	        $resources_to_publications->to_labels = array(
		        'create'        => Translate::translate( 'Select Resource' ),
		        'singular_name' => Translate::translate( 'Resource' ),
		        'search_items'  => Translate::translate( 'Search Resources' ),
		        'not_found'     => Translate::translate( 'No Resource found.' ),
	        );
	        #endresources_to_publications

	        #team_to_news
	        $team_to_news = $team->addRelationship( 'team_to_news', $news );
	        $team_to_news->title = array(
		        'from' => Translate::translate( 'News' ),
		        'to'   => Translate::translate( 'Persons from IBS' ),
            );
	        $team_to_news->to_labels = array(
		        'create'        => Translate::translate( 'Select Person' ),
		        'singular_name' => Translate::translate( 'Person' ),
		        'search_items'  => Translate::translate( 'Search persons' ),
		        'not_found'     => Translate::translate( 'No person found.' ),
	        );

	        $team_to_news->from_labels = array(
		        'create'        => Translate::translate( 'Select news' ),
		        'singular_name' => Translate::translate( 'News' ),
		        'search_items'  => Translate::translate( 'Search news' ),
		        'not_found'     => Translate::translate( 'No news found.' ),
	        );
			#end team_to_news
			#team_to_research
	        $team_to_research = $team->addRelationship( 'team_to_research', $research );
	        $team_to_research->title = array(
		        'from' => Translate::translate( 'Research' ),
		        'to'   => Translate::translate( 'Persons from IBS' ),
	        );
	        $team_to_research->to_labels = array(
		        'create'        => Translate::translate( 'Select research' ),
		        'singular_name' => Translate::translate( 'Research' ),
		        'search_items'  => Translate::translate( 'Search researches' ),
		        'not_found'     => Translate::translate( 'No research found.' ),
	        );
	        $team_to_research->from_labels = array(
		        'create'        => Translate::translate( 'Select Person' ),
		        'singular_name' => Translate::translate( 'Person' ),
		        'search_items'  => Translate::translate( 'Search persons' ),
		        'not_found'     => Translate::translate( 'No person found.' ),
	        );
	        #end team_to_research

	        #events_to_research
	        $events_to_research = $events->addRelationship( 'events_to_research', $research );
	        $events_to_research->admin_box = array(
		        'show' => 'from'
	        );
	        $events_to_research->title = Translate::translate( 'Research' );
	        $events_to_research->to_labels = array(
		        'create'        => Translate::translate( 'Select Research' ),
		        'singular_name' => Translate::translate( 'Research' ),
		        'search_items'  => Translate::translate( 'Search Researches' ),
		        'not_found'     => Translate::translate( 'No research found.' ),
	        );
	        #end events_to_research
			#events_to_resources
	        $events_to_resources = $events->addRelationship( 'events_to_resources', $resources );
	        $events_to_resources->admin_box = array(
		        'show' => 'from'
	        );
	        $events_to_resources->title = Translate::translate( 'Resources' );
	        $events_to_resources->to_labels = array(
		        'create'        => Translate::translate( 'Select Resource' ),
		        'singular_name' => Translate::translate( 'Resource' ),
		        'search_items'  => Translate::translate( 'Search Resources' ),
		        'not_found'     => Translate::translate( 'No Resource found.' ),
	        );
			#end events_to_resources
//			\SilverWp\Ajax\Tweetie::getInstance();
	        #widgets
	        //new Widget\Social();
	        #endwidgets
			if ( is_plugin_active('sitepress-multilingual-cms/inc/wpml-api.php') ) {
				new Import();
				if ( function_exists( 'icl_object_id' ) ) {
					Wpml::getInstance();
				}
			}
        } catch ( Exception $ex ) {
            echo $ex->catchException();
        }
    }
} );
