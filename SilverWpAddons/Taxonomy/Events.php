<?php
namespace SilverWpAddons\Taxonomy;

use SilverWp\Translate;
use SilverWp\Taxonomy\TaxonomyAbstract;

if ( ! class_exists( 'SilverWpAddons\Taxonomy\Events' ) ) {
	/**
	 * taxonomy for Events
	 *
	 * @author     Michal Kalkowski <michal at silversite.pl>
	 * @category   WordPress
	 * @package    SilverWpAddons
	 * @subpackage Taxonomy
	 * @copyright  SilverSite.pl (c) 2015
	 * @version    1.0
	 */
	class Events extends TaxonomyAbstract {
		protected $exclude_columns = array( 'category', 'tag' );

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
			) );
			$this->setLabels( 'category', array(
				'name'                       => Translate::translate( 'Event category' ),
				'singular_name'              => Translate::translate( 'Event type' ),
				'menu_name'                  => Translate::translate( 'Event category' ),
				'all_items'                  => Translate::translate( 'All events category' ),
				'separate_items_with_commas' => Translate::translate( 'Separate Event category with commas' ),
				'choose_from_most_used'      => Translate::translate( 'Choose from the most often used Event category' ),
				'add_new_item'               => Translate::translate( 'Add new Category' ),
			) );
		}
	}
}
