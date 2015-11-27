<?php

/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace SilverWpAddons\Taxonomy;


use SilverWp\Taxonomy\TaxonomyAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\Taxonomy\Currency' ) ) {

	/**
	 *
	 * Taxonomies for Currency post type
	 *
	 * @category   WordPress
	 * @package    SilverWpAddons
	 * @subpackage Taxonomy
	 * @author     Michal Kalkowski <michal at silversite.pl>
	 * @copyright  SilverSite.pl (c) 2015
	 * @version    1.0
	 */
	class Currency extends TaxonomyAbstract {
		protected $exclude_columns = array( 'category', 'tag' );
		protected $debug = true;
		/**
		 * Set up taxonomy class labels etc.
		 *
		 * @since  0.2
		 * @access protected
		 */
		protected function setUp() {
			$this->add( 'continent', array(
				'public'             => true,
				'show_in_nav_menus'  => true,
				//show meta box in post type edit area
				'show_ui'            => true,
				'show_tagcloud'      => false,
				'hierarchical'       => true,
				'query_var'          => true,
				'custom_single_view' => true,
				'show_admin_column'  => false,
			) );

			$this->setLabels( 'category', array(
				'name'                       => Translate::translate( 'Continents' ),
				'singular_name'              => Translate::translate( 'Continent' ),
				'menu_name'                  => Translate::translate( 'Continents' ),
				'all_items'                  => Translate::translate( 'All Continents' ),
				'separate_items_with_commas' => Translate::translate( 'Separate Continents with commas' ),
				'choose_from_most_used'      => Translate::translate( 'Choose from the most often used Continents' ),
				'add_new_item'               => Translate::translate( 'Add new Continent' ),
			) );
		}
	}
}