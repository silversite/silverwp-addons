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

use SilverWp\Helper\Control\Attachments;
use SilverWp\Helper\Control\Checkbox;
use SilverWp\Helper\Control\Date;
use SilverWp\Helper\Control\Gallery;
use SilverWp\Helper\Control\Group;
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Helper\Control\Wpeditor;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\News' ) ) {
	/**
	 * News Meta box for News Post Type
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id:$
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class News extends MetaBoxAbstract {
		protected $priority = 'low';

		protected function setUp() {

			$attachments = new Attachments( 'attachments' );
			$this->addControl( $attachments );

			$checkbox = new Checkbox( 'main_page_promo' );
			$checkbox->setLabel( Translate::translate( 'Promotion on main page' ) );
			$this->addControl( $checkbox );
		}
	}
}
