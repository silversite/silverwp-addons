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

if ( ! class_exists( '\SilverWpAddons\Comments' ) ) {
	/**
	 * Comments custom post type
	 *
	 * @property array labels
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Revision:$
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    PostType
	 * @copyright     SilverSite.pl (c) 2015
	 */
	class Comments extends PostTypeAbstract {
		protected $name = 'comments';
		protected $supports = array( 'title', 'thumbnail', 'editor' );

		/**
		 *
		 * Set up Custom Post Type. In this method will be set up labels and all
		 * register_post_type function arguments
		 *
		 * @access protected
		 */
		protected function setUp() {
			$this->exclude_from_search = false;
			$this->labels = array(
				'menu_name'      => Translate::translate( 'Comments' ),
				'name'           => Translate::translate( 'Comments' ),
				'name_admin_bar' => Translate::translate( 'Comments' ),
				'all_items'      => Translate::translate( 'All Comments' )
			);
		}
	}
}
