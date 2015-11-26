<?php
namespace SilverWpAddons;

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

/**
 *
 *
 *
 * @category  WordPress
 * @package
 * @author    Michal Kalkowski <michal at silversite.pl>
 * @copyright SilverSite.pl 2015
 * @version   $Revision:$
 */
class NavMenu extends \SilverWp\Helper\NavMenu {

	/**
	 * Remove search icon form menu
	 *
	 * @param string $items
	 * @param object $args
	 *
	 * @return string|void
	 * @access public
	 */
	public function addSearchForm( $items, $args ) {
		return $items;
	}
}