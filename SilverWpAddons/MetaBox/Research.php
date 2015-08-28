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
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Research' ) ) {
	/**
	 * Research Meta box for Research Post Type
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id:$
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Research extends MetaBoxAbstract {
		protected $priority = 'low';
		protected $exclude_columns = array( 'category', 'tag' );

		protected function createMetaBox() {

			$text_area = new Textarea( 'partners' );
			$text_area->setLabel( Translate::translate( 'Partners' ) );
			$this->addMetaBox( $text_area );
			//todo add P2P connect with team

			$text_area = new Textarea( 'contact' );
			$text_area->setLabel( Translate::translate( 'Contact' ) );
			$this->addMetaBox( $text_area );

			$url = new Text( 'external_url' );
			$url->setLabel( Translate::translate( 'External URL' ) );
			$url->setValidation( 'url' );
			$this->addMetaBox( $text_area );

			$attachments = new Attachments( 'attachments' );
			$this->addMetaBox( $attachments );

			//todo add P2P autocomplete connect with publication

		}
	}
}