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

use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Authors' ) ) {
	/**
	 * Authors Meta box for Authors Post Type
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id:$
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Authors extends MetaBoxAbstract {
		protected $exclude_columns = array( 'category', 'tag', 'author' );

		protected function setUp() {

			$this->setEnterTitleHearLabel( Translate::translate( 'Name and last name' ) );

			$text_area = new Textarea( 'affiliation' );
			$text_area->setLabel( Translate::translate( 'Affiliation' ) );
			$this->addControl( $text_area );

			$text = new Text( 'email' );
			$text->setLabel( Translate::translate( 'E-mail' ) );
			$text->setValidation( 'email' );
			$this->addControl( $text );
		}
	}
}
