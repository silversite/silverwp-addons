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
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Team' ) ) {
	/**
	 * Team Meta box for Team Post Type
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id:$
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Team extends MetaBoxAbstract {

		protected function createMetaBox() {

			$this->setEnterTitleHearLabel( Translate::translate( 'Name and last name' ) );

			$text = new Text( 'email' );
			$text->setLabel( Translate::translate( 'E-mail' ) );
			$text->setValidation( 'email' );
			$this->addMetaBox( $text );

			$text = new Text( 'affiliation' );
			$text->setLabel( Translate::translate( 'Affiliation' ) );
			$this->addMetaBox( $text );

			$text_area = new Textarea( 'contact' );
			$text_area->setLabel( Translate::translate( 'Contact' ) );
			$this->addMetaBox( $text_area );

			$checkbox = new Checkbox( 'show_in_team_page' );
			$checkbox->setLabel( Translate::translate( 'Show in Team page' ) );
			$this->addMetaBox( $checkbox );
		}
	}
}
