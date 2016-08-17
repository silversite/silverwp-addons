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
use SilverWp\Helper\Control\Group;
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Helper\Control\Wpeditor;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Research' ) ) {
	/**
	 * Research Meta box for Research Post Type
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       1.1
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright     SilverSite.pl (c) 2015
	 */
	class Research extends MetaBoxAbstract {
		protected $priority = 'low';
		protected $exclude_columns = array( 'category', 'tag' );

		protected function setUp() {

			$realization_time = new Text( 'realization_time' );
			$realization_time->setLabel( Translate::translate( 'Realization time' ) );
			$this->addControl( $realization_time );

			$partners = new Wpeditor( 'partners' );
			$partners->setLabel( Translate::translate( 'Partners' ) );
			$this->addControl( $partners );

			$contact = new Textarea( 'contact' );
			$contact->setLabel( Translate::translate( 'Contact' ) );
			$this->addControl( $contact );

			$external_url = new Text( 'external_url' );
			$external_url->setLabel( Translate::translate( 'External URL' ) );
			$external_url->setValidation( 'url' );
			$this->addControl( $external_url );

			$group = new Group( 'persons' );
			$group->setLabel( Translate::translate( 'Persons engage in project' ) );
			$group->setSortable( true );
			$group->setRepeating( true );

			$label = new Text( 'label' );
			$label->setLabel( Translate::translate( 'Label' ) );
			$group->addControl( $label );

			$name = new Text( 'person' );
			$name->setLabel( Translate::translate( 'Person' ) );
			$group->addControl( $name );
			$this->addControl( $group );

			$attachments = new Attachments( 'attachments' );
			$this->addControl( $attachments );

		}
	}
}
