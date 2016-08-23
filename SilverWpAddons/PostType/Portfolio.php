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

use SilverWp\Helper\RecursiveArray;
use SilverWp\PostType\PostTypeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\Portfolio' ) ) {
    /**
     * Portfolio custom post type
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: Portfolio.php 2184 2015-01-21 12:20:08Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage PostType
     * @copyright (c) SilverSite.pl 2015
     */
    class Portfolio extends PostTypeAbstract {
        protected $name = 'portfolio';
        protected $supports = array( 'title', 'editor', 'thumbnail', 'comments' );

        /**
         *
         * Class setup
         *
         * @access protected
         */
        protected function setUp() {
            $this->labels = array(
                'menu_name'      => Translate::translate( 'Portfolio' ),
                'name'           => Translate::translate( 'Portfolio Projects' ),
                'name_admin_bar' => Translate::translate( 'Portfolio' ),
                'all_items'      => Translate::translate( 'All Portfolio' )
            );
        }
	}
}
