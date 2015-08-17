<?php
namespace SilverWpAddons\Taxonomy;

use SilverWp\Translate;
use SilverWp\Taxonomy\TaxonomyAbstract;

if ( ! class_exists( 'SilverWpAddons\Taxonomy\Publications' ) ) {
	/**
	 * Taxonomy for Publications
	 *
	 * @author     Michal Kalkowski <michal at silversite.pl>
	 * @category   WordPress
	 * @package    SilverWpAddons
	 * @subpackage Taxonomy
	 * @copyright  SilverSite.pl (c) 2015
	 * @version    $Revision:$
	 */
	class Publications extends TaxonomyAbstract {

		/**
		 * Set up taxonomy class labels etc.
		 *
		 * @since  0.2
		 * @access protected
		 */
		protected function setUp() {
			$this->add( 'type', array(
				'public'            => true,
				'show_in_nav_menus' => true,
				//show meta box in post type edit area
				'show_ui'           => true,
				'show_tagcloud'     => false,
				'hierarchical'      => false,
				'query_var'         => true,
				'custom_meta_box' => array(
					'control_type'    => 'select',
					// Priority of the metabox placement.
					'priority'        => 'high',
					// 'normal' to move it under the post content.
					'context'         => 'normal',
					// Custom title for your metabox
					'metabox_title'   => Translate::translate( 'Select type' ),
					// Makes a selection required.
					'force_selection' => true,
					// Will keep radio elements from indenting for child-terms.
					'indented'        => false,
					// Allows adding of new terms from the metabox
					'allow_new_terms' => true
				)
			) );
			$this->setLabels( 'type', array(
				'name'                       => Translate::translate( 'Publications types' ),
				'singular_name'              => Translate::translate( 'Publication type' ),
				'menu_name'                  => Translate::translate( 'Publications types' ),
				'all_items'                  => Translate::translate( 'All Publications types' ),
				'separate_items_with_commas' => Translate::translate( 'Separate Publications types with commas' ),
				'choose_from_most_used'      => Translate::translate( 'Choose from the most often used Publications types' ),
				'add_new_item'               => Translate::translate( 'Add new Type' ),
			) );

			$this->add( 'category', array(
				'public'            => true,
				'show_in_nav_menus' => true,
				//show meta box in post type edit area
				'show_ui'           => true,
				'show_tagcloud'     => false,
				'hierarchical'      => false,
				'query_var'         => true,
			) );

			$this->setLabels( 'category', array(
				'name'                       => Translate::translate( 'Publications categories' ),
				'singular_name'              => Translate::translate( 'Publication category' ),
				'menu_name'                  => Translate::translate( 'Publications categories' ),
				'all_items'                  => Translate::translate( 'All Publications categories' ),
				'separate_items_with_commas' => Translate::translate( 'Separate Publications categories with commas' ),
				'choose_from_most_used'      => Translate::translate( 'Choose from the most often used Publications categories' ),
				'add_new_item'               => Translate::translate( 'Add new Category' ),
			) );

			$this->add( 'jel', array(
				'public'            => true,
				'show_in_nav_menus' => true,
				//show meta box in post type edit area
				'show_ui'           => true,
				'show_tagcloud'     => true,
				'hierarchical'      => false,
				'query_var'         => true,
			) );

			$this->setLabels( 'jel', array(
				'name'                       => Translate::translate( 'Publications JEL' ),
				'singular_name'              => Translate::translate( 'Publication JEL' ),
				'menu_name'                  => Translate::translate( 'Publications JEL' ),
				'all_items'                  => Translate::translate( 'All Publications JEL' ),
				'separate_items_with_commas' => Translate::translate( 'Separate Publications JEL with commas' ),
				'choose_from_most_used'      => Translate::translate( 'Choose from the most often used Publications JEL' ),
				'add_new_item'               => Translate::translate( 'Add new JEL' ),
			) );

		}
	}
}
