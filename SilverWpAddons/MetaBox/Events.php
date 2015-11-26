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

		protected function setUp() {

			$attachments = new Attachments( 'attachments' );
			$this->addControl( $attachments );

			$checkbox = new Checkbox( 'main_page_promo' );
			$checkbox->setLabel( Translate::translate( 'Promotion on main page' ) );
			$this->addControl( $checkbox );


			$place = new Text( 'place' );
			$place->setLabel( Translate::translate( 'Place' ) );
			$this->addControl( $place );

			$address = new Text( 'address' );
			$address->setLabel( Translate::translate( 'Event address' ) );
			$this->addControl( $address );

			$program = new Group( 'program' );
			$program->setLabel( Translate::translate( 'Program' ) );
			$program->setRepeating( true );
			$program->setSortable( true );

			$label = new Text( 'title' );
			$label->setLabel( Translate::translate( 'Title' ) );
			$program->addControl( $label );

			$description = new Wpeditor( 'description' );
			$description->setLabel( Translate::translate( 'Description' ) );
			$program->addControl( $description );

			$this->addControl( $program );

			$start = new Group( 'start' );
			$start->setLabel( Translate::translate( 'Start' ) );

			$date = new Date( 'date_start' );
			$date->setLabel( Translate::translate( 'Date start' ) );
			$start->addControl( $date );

			$time = new Text( 'time_start' );
			$time->setLabel( Translate::translate( 'Time start' ) );
			$start->addControl( $time );
			$this->addControl( $start );

			$end = new Group( 'end' );
			$end->setLabel( Translate::translate( 'End' ) );

			$date = new Date( 'date_end' );
			$date->setLabel( Translate::translate( 'Date end' ) );
			$end->addControl( $date );

			$time = new Text( 'time_end' );
			$time->setLabel( Translate::translate( 'Time end' ) );
			$end->addControl( $time );
			$this->addControl( $end );

		}
	}
}
