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
        protected $taxonomies = array(
            array(
                'name' => 'category',
                'args' => array(
                    'public'            => true,
                    'show_in_nav_menus' => true,
                    'show_ui'           => true,
                    'show_tagcloud'     => false,
                    'hierarchical'      => true,
                    'query_var'         => true
                ),
            ),
            array(
                'name' => 'tag',
                'args' => array(
                    'public'            => true,
                    'show_in_nav_menus' => true,
                    'show_ui'           => true,
                    'show_tagcloud'     => true,
                    'hierarchical'      => false,
                    'query_var'         => false
                ),
            ),
        );

        protected function setLabels() {
            $this->labels[ 'category' ] = array(
                'name'                       => Translate::translate( 'Portfolio categories' ),
                'singular_name'              => Translate::translate( 'Portfolio category' ),
                'menu_name'                  => Translate::translate( 'Portfolio categories' ),
                'all_items'                  => Translate::translate( 'All Portfolio categories' ),
                'parent_item'                => Translate::translate( 'Parent Portfolio category' ),
                'parent_item_colon'          => Translate::translate( 'Parent Portfolio category' ),
                'update_item'                => Translate::translate( 'Update Portfolio category' ),
                'separate_items_with_commas' => Translate::translate( 'Separate Portfolio categories with commas' ),
                'choose_from_most_used'      => Translate::translate( 'Choose from the most often used Portfolio categories' ),
            );

            $this->labels[ 'tag' ] = array(
                'name'                       => Translate::translate( 'Portfolio tags' ),
                'singular_name'              => Translate::translate( 'Portfolio tag' ),
                'menu_name'                  => Translate::translate( 'Portfolio tags' ),
                'all_items'                  => Translate::translate( 'All Portfolio tags' ),
                'parent_item'                => Translate::translate( 'Parent Portfolio tag' ),
                'parent_item_colon'          => Translate::translate( 'Parent Portfolio tag' ),
                'update_item'                => Translate::translate( 'Update Portfolio tag' ),
                'separate_items_with_commas' => Translate::translate( 'Separate Portfolio tags with commas' ),
                'choose_from_most_used'      => Translate::translate( 'Choose from the most often used Portfolio tags' ),
            );
        }
    }
}
