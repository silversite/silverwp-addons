<?php
namespace SilverWpAddons\Taxonomy;

use SilverWp\Translate;
use SilverWp\Taxonomy\TaxonomyAbstract;

if ( ! class_exists( '\SilverWpAddons\Taxonomy\Resources' ) ) {
	/**
	 * Taxonomy for Resources
	 *
	 * @author     Michal Kalkowski <michal at silversite.pl>
	 * @category   WordPress
	 * @package    SilverWpAddons
	 * @subpackage Taxonomy
	 * @copyright  SilverSite.pl (c) 2015
	 * @version    1.0
	 */
	class Resources extends TaxonomyAbstract {
		/**
		 * Remove this columns from edita table list
		 * @var array
		 */
		protected $exclude_columns = array( 'tag' );

		/**
		 * Set up taxonomy class labels etc.
		 *
		 * @since  0.6
		 * @access protected
		 */
		protected function setUp() {
			$this->add(
				'category',
				array(
					'public'            => true,
					'show_in_nav_menus' => true,
					//show meta box in post type edit area
					'show_ui'           => true,
					'show_tagcloud'     => false,
					'hierarchical'      => true,
					'query_var'         => true,
					'display_column'    => true,
				)
			);

			$this->setLabels(
				'category',
				array(
					'name'                       => Translate::translate( 'Resources categories' ),
					'singular_name'              => Translate::translate( 'Resource category' ),
					'menu_name'                  => Translate::translate( 'Resources categories' ),
					'all_items'                  => Translate::translate( 'All Resources categories' ),
					'separate_items_with_commas' => false,
					'choose_from_most_used'      => false,
					'add_new_item'               => Translate::translate( 'Add new Category' ),
				)
			);
		}
	}
}
