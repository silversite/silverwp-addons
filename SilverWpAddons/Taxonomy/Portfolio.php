<?php
namespace SilverWpAddons\Taxonomy;

use SilverWp\Translate;
use SilverWp\Taxonomy\TaxonomyAbstract;

if ( ! class_exists('SilverWpAddons\Taxonomy\Portfolio')) {
    /**
     * taxonomy for portfolio
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage Taxonomy
     * @copyright SilverSite.pl 2015
     * @version $Revision:$
     */
    class Portfolio extends TaxonomyAbstract {

	    protected $exclude_columns = array( 'category' );

	    /**
	     * Set up taxonomy class labels etc.
	     *
	     * @since  0.2
	     * @access protected
	     */
	    protected function setUp() {
		    $this->add( 'category', array(
			    'public'             => true,
			    'show_in_nav_menus'  => true,
			    //show meta box in post type edit area
			    'show_ui'            => true,
			    'show_tagcloud'      => false,
			    'hierarchical'       => true,
			    'query_var'          => true,
			    'custom_single_view' => true,
			    'show_admin_column'  => true,
		        )
		    );

		    $this->setLabels('category', array(
			    'name'                       => Translate::translate( 'Portfolio categories' ),
			    'singular_name'              => Translate::translate( 'Portfolio category' ),
			    'menu_name'                  => Translate::translate( 'Portfolio categories' ),
			    'all_items'                  => Translate::translate( 'All Portfolio categories' ),
			    'parent_item'                => Translate::translate( 'Parent Portfolio category' ),
			    'parent_item_colon'          => Translate::translate( 'Parent Portfolio category' ),
			    'update_item'                => Translate::translate( 'Update Portfolio category' ),
			    'separate_items_with_commas' => Translate::translate( 'Separate Portfolio categories with commas' ),
			    'choose_from_most_used'      => Translate::translate( 'Choose from the most often used Portfolio categories' ),
		        )
		    );
		}
    }
}
