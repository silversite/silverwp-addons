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
				'silverwp-flickr',
				'SilverWp Flickr',
				$widget_options
			);

			// Configure the widget fields
			$title = new Text( 'title' );
			$title->setLabel( Translate::translate( 'Title' ) );
			$title->setDefault( 'Flickr Widget' );
			$this->addControl( $title );

			$type = new Select( 'type' );
			$type->setShowEmpty( false );
			$type->setLabel( Translate::translate( 'Type' ) );
			$type->addOption( 'user', Translate::translate( 'user' ) );
			$type->addOption( 'group', Translate::translate( 'group' ) );
			$type->setDefault( 'user' );
			$this->addControl( $type );

			$flickr_id = new Text( 'flickr_id' );
			$flickr_id->setDescription(
				Translate::translate(
					'Put the flickr ID here (example: 52617155@N08) or go to <a href="http://idgettr.com/" target="_blank">idGettr</a> if you don\'t know ID.'
				)
			);
			$flickr_id->setLabel( Translate::translate( 'Flickr ID' ) );
			$flickr_id->setDefault( '' );
			$this->addControl( $flickr_id );

			$count = new Select( 'count' );
			$count->setLabel( Translate::translate( 'Number of images to show' ) );
			$count->setShowEmpty( false );
			$count->setDefault( 5 );
			$count->setStart( 1 );
			$count->setEnd( 10 );
			$this->addControl( $count );

			$display_method = new Select( 'display' );
			$display_method->setShowEmpty( false );
			$display_method->setLabel( Translate::translate( 'Display Method' ) );
			$display_method->addOption( 'latest', Translate::translate( 'latest' ) );
			$display_method->addOption( 'random', Translate::translate( 'random' ) );
			$display_method->setDefault( 'latest' );
			$this->addControl( $display_method );

		}
	}
}
