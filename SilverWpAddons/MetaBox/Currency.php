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

namespace SilverWpAddons\MetaBox;


use SilverWp\Helper\Control\Checkbox;
use SilverWp\Helper\Control\Gallery;
use SilverWp\Helper\Control\Text;
use SilverWp\MetaBox\MetaBoxAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\MetaBox\Currency' ) ) {

	/**
	 *
	 * Custom meta boxes for currency post type
	 *
	 * @category   WordPress
	 * @package    SilverWpAddons
	 * @subpackage MetaBox
	 * @author     Michal Kalkowski <michal at silversite.pl>
	 * @copyright  SilverSite.pl (c) 2015
	 * @version    1.0
	 */
	class Currency extends MetaBoxAbstract {

		/**
		 *
		 * In this method we set up our meta boxes and all other settings
		 *
		 * @access protected
		 */
		protected function setUp() {
			$country = new Text( 'country' );
			$country->setLabel( Translate::translate( 'Country' ) );
			$this->addControl( $country );

			$description = new Text( 'description' );
			$description->setLabel( Translate::translate( 'Description' ) );
			$this->addControl( $description );

			$main_page = new Checkbox( 'main_page' );
			$main_page->setLabel( Translate::translate( 'Display on home?' ) );
			$this->addFilterControl( $main_page );

			$gallery = new Gallery( 'gallery' );
			$description = new Text( 'image_desc' );
			$description->setLabel( Translate::translate( 'Image description' ) );
			$gallery->addControl($description);

			$this->addControl( $gallery );
		}
	}
}