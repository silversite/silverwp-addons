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
namespace SilverWpAddons\Widget;

use SilverWp\Helper\Control\CategoriesCheckboxes;
use SilverWp\Helper\Control\Checkbox;
use SilverWp\Helper\Control\Number;
use SilverWp\Helper\Control\Select;
use SilverWp\Helper\Control\Text;
use SilverWp\Widget\WidgetAbstract;
use SilverWp\Translate;

if ( ! class_exists( 'SilverWpAddons\Widget\Flickr' ) ) {
	/**
	 * Recent Posts Widget
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       0.4
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    Widget
	 * @copyright     2009 - 2015 (c) SilverSite.pl
	 */
	class Flickr extends WidgetAbstract {
		public function __construct() {

			$widget_options = array(
				'description' => Translate::translate( 'Displays a Flickr photo stream from an ID.' ),
			);
			parent::__construct(
				'flickr',
				Translate::translate( 'Flickr' ),
				$widget_options
			);

			// Configure the widget fields
			$title = new Text( 'title' );
			$title->setLabel( Translate::translate( 'Title' ) );
			$title->setDefault( Translate::translate( 'Flickr Widget' ) );
			$this->addControl( $title );

			$type = new Select( 'type' );
			$type->setLabel( Translate::translate( 'Type' ) );
			$type->setDescription( Translate::translate( 'The type of images from user or group.' ) );
			$type->addOption( 'user', Translate::translate( 'user' ) );
			$type->addOption( 'group', Translate::translate( 'group' ) );
			$this->addControl( $type );

			$flickr_id = new Text( 'flickr_id' );
			$flickr_id->setDescription(
				Translate::translate(
					'Put the flickr ID here, go to <a href="http://goo.gl/PM6rZ" target="_blank">Flickr NSID Lookup</a> if you don\'t know your ID. Example: 71865026@N00'
				)
			);
			$flickr_id->setLabel( Translate::translate( 'Flickr ID' ) );
			$flickr_id->setDefault( '71865026@N00' );
			$this->addControl( $flickr_id );

			$count = new Number( 'count' );
			$count->setLabel( Translate::translate( 'Number of images to show' ) );
			$count->setDefault( 5 );
			$count->setDescription( Translate::translate( 'Number of images shown from 1 to 10' ) );
			$this->addControl( $count );

			$display_method = new Select( 'display' );
			$display_method->setLabel( Translate::translate( 'Display Method' ) );
			$display_method->setDescription( Translate::translate( 'Get the image from recent or use random function' ) );
			$display_method->addOption( 'latest', Translate::translate( 'latest' ) );
			$display_method->addOption( 'random', Translate::translate( 'random' ) );
			$this->addControl( $display_method );

		}
	}
}
