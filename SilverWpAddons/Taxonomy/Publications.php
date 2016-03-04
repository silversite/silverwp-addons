<?php
namespace SilverWpAddons\Taxonomy;

use SilverWp\Translate;
use SilverWp\Taxonomy\TaxonomyAbstract;

if ( ! class_exists( '\SilverWpAddons\Taxonomy\Publications' ) ) {
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
		 * Remove this columns from edita table list
		 * @var array
		 */
		protected $exclude_columns = array( 'tag', 'category' );

		/**
		 * Set up taxonomy class labels etc.
		 *
		 * @since  0.2
		 * @access protected
		 */
		protected function setUp() {
			global $wp_rewrite;
			$this->add( 'types', array(
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
			$this->setLabels( 'types', array(
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
				'hierarchical'      => true,
				'query_var'         => true,
				'display_column'    => true,
			) );

			$this->setLabels( 'category', array(
				'name'                       => Translate::translate( 'Publications categories' ),
				'singular_name'              => Translate::translate( 'Publication category' ),
				'menu_name'                  => Translate::translate( 'Publications categories' ),
				'all_items'                  => Translate::translate( 'All Publications categories' ),
				'separate_items_with_commas' => false,
				'choose_from_most_used'      => false,
				'add_new_item'               => Translate::translate( 'Add new Category' ),
			) );
			//TODO fix autocomplete
			$this->add( 'jel', array(
				'public'            => true,
				'hierarchical'      => false,
				//show meta box in post type edit area
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => false,
				'query_var'         => 'jel',
				'rewrite' => array(
					'hierarchical' => false,
					'slug'         => get_option( 'tag_base' ) ? get_option( 'tag_base' ) : 'jel',
					'with_front'   => ! get_option( 'tag_base' ) || $wp_rewrite->using_index_permalinks(),
					'ep_mask'      => EP_TAGS,
				),
				'show_tagcloud'     => true,
				'_builtin'          => true,
			) );

			$this->setLabels( 'jel', array(
				'name'                       => Translate::translate( 'JEL codes' ),
				'singular_name'              => Translate::translate( 'JEL code' ),
				'menu_name'                  => Translate::translate( 'JEL codes' ),
				'all_items'                  => Translate::translate( 'All JEL codes' ),
				'separate_items_with_commas' => Translate::translate( 'Separate JEL codes with commas' ),
				'choose_from_most_used'      => Translate::translate( 'Choose from the most often used JEL codes' ),
				'add_new_item'               => Translate::translate( 'Add new JEL code' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
			) );

		}
	}
}
