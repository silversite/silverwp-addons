<?php
namespace SilverWpAddons\Taxonomy;

use SilverWp\Translate;
use SilverWp\Taxonomy\TaxonomyAbstract;

if ( ! class_exists( 'SilverWpAddons\Taxonomy\News' ) ) {
	/**
	 * taxonomy for News
	 *
	 * @author     Michal Kalkowski <michal at silversite.pl>
	 * @category   WordPress
	 * @package    SilverWpAddons
	 * @subpackage Taxonomy
	 * @copyright  SilverSite.pl (c) 2015
	 * @version    1.0
	 */
	class News extends TaxonomyAbstract {
		protected $exclude_columns = array( 'category', 'tag' );

		/**
		 * Set up taxonomy class labels etc.
		 *
		 * @since  0.2
		 * @access protected
		 */
		protected function setUp() {
			$this->add( 'type', array(
				'public'             => true,
				'show_in_nav_menus'  => true,
				//show meta box in post type edit area
				'show_ui'            => true,
				'show_tagcloud'      => false,
				'hierarchical'       => false,
				'query_var'          => true,
				'custom_single_view' => true,
				'rewrite'           => array(
					'slug'       => 'types',
					'with_front' => true
				),
//				'custom_meta_box'   => array(
//					'control_type'    => 'select',
//					// Priority of the metabox placement.
//					'priority'        => 'high',
//					// 'normal' to move it under the post content.
//					'context'         => 'normal',
//					// Custom title for your metabox
//					'metabox_title'   => Translate::translate( 'Select type' ),
//					// Makes a selection required.
//					'force_selection' => true,
//					// Will keep radio elements from indenting for child-terms.
//					'indented'        => false,
//					// Allows adding of new terms from the metabox
//					'allow_new_terms' => true
//				),
				'display_column' => true
			) );
			$this->setLabels( 'type', array(
				'name'                       => Translate::translate( 'News types' ),
				'singular_name'              => Translate::translate( 'News type' ),
				'menu_name'                  => Translate::translate( 'News types' ),
				'all_items'                  => Translate::translate( 'All events types' ),
				'separate_items_with_commas' => Translate::translate( 'Separate News types with commas' ),
				'choose_from_most_used'      => Translate::translate( 'Choose from the most often used News types' ),
				'add_new_item'               => Translate::translate( 'Add new Type' ),
			) );
		}
	}
}
