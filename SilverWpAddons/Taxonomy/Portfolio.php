<?php
namespace SilverWpAddons\Taxonomy;

use SilverWp\Translate;
use SilverWp\Taxonomy\TaxonomyAbstract;

if (!class_exists('SilverWpAddons\Taxonomy\Portfolio')) {
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
    class Portfolio extends TaxonomyAbstract
    {
        /**
         * Set up taxonomy class labels etc.
         *
         * @since  0.2
         * @access protected
         */
        protected function setUp()
        {
            // Categories
            $this->add('category', array(
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true,
                'query_var' => true,
                'custom_single_view' => true,
                'show_admin_column' => true,
            ));
            $this->setLabels('category', array(
                'name' => Translate::translate('Categories'),
                'singular_name' => Translate::translate('Project type'),
                'menu_name' => Translate::translate('Categories'),
                'all_items' => Translate::translate('All projects of category'),
                'separate_items_with_commas' => Translate::translate('Separate project category with commas'),
                'choose_from_most_used' => Translate::translate('Choose from the most often used project category'),
                'add_new_item' => Translate::translate('Add new category'),
            ));

            // Tags
            $this->add('tag', array(
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => true,
                'hierarchical' => false,
                'query_var' => true,
                'custom_single_view' => true,
                'show_admin_column' => true,
            ));
            $this->setLabels('tag', array(
                'name' => Translate::translate('Tags'),
                'singular_name' => Translate::translate('Project type'),
                'menu_name' => Translate::translate('Tags'),
                'all_items' => Translate::translate('All projects of tag'),
                'separate_items_with_commas' => Translate::translate('Separate project tag with commas'),
                'choose_from_most_used' => Translate::translate('Choose from the most often used project tag'),
                'add_new_item' => Translate::translate('Add new tag'),
            ));
        }
    }
}
