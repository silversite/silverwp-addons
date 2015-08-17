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
use SilverWp\Helper\Control\Wpeditor;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Events' ) ) {
	/**
	 * Events Meta box for Events Post Type
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id:$
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Events extends MetaBoxAbstract {
		protected $priority = 'low';

		protected function createMetaBox() {

			$gallery = new Gallery( 'gallery' );
			$gallery->setLabel( Translate::translate( 'Gallery' ) );
			$this->addMetaBox( $gallery );

			$attachments = new Attachments( 'attachments' );
			$this->addMetaBox( $attachments );

			$checkbox = new Checkbox( 'main_page_promo' );
			$checkbox->setLabel( Translate::translate( 'Promotion on main page' ) );
			$this->addMetaBox( $checkbox );

			$group = new Group( 'event' );
			$group->setLabel( Translate::translate( 'Event' ) );

			$editor = new Wpeditor( 'program' );
			$editor->setLabel( Translate::translate( 'Program' ) );
			$group->addControl( $editor );

			$date = new Date( 'date' );
			$date->setLabel( Translate::translate( 'Date' ) );
			$group->addControl( $date );

			$time = new Text( 'time' );
			$time->setLabel( Translate::translate( 'Time' ) );
			$group->addControl( $time );

			$place = new Text( 'place' );
			$place->setLabel( Translate::translate( 'Place' ) );
			$group->addControl( $place );

			$this->addMetaBox( $group );
		}
	}
}
