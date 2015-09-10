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

namespace SilverWpAddons\PostType;

use SilverWp\PostType\PostTypeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\Research' ) ) {
	/**
	 * Research custom post type
	 *
	 * @property array labels
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       0.3
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    PostType
	 * @copyright     SilverSite.pl (c) 2015
	 */
	class Research extends PostTypeAbstract {
		protected $name = 'research';
		protected $supports = array( 'title', 'editor', 'thumbnail' );

		/**
		 *
		 * Set up Custom Post Type. In this method will be set up labels and all
		 * register_post_type function arguments
		 *
		 * @access protected
		 */
		protected function setUp() {
			$this->labels = array(
				'menu_name'      => Translate::translate( 'Research' ),
				'name'           => Translate::translate( 'Research' ),
				'name_admin_bar' => Translate::translate( 'Research' ),
				'all_items'      => Translate::translate( 'All Research' )
			);
		}
	}
}
