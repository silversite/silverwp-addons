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

use SilverWp\Helper\Control\Checkbox;
use SilverWp\Helper\Control\Text;
use SilverWp\Translate;
use SilverWp\Widget\WidgetAbstract;

if ( ! class_exists( 'SilverWpAddons\Widget\Social' ) ) {
	/**
	 * Social bookmarks list
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       0.5
	 * @category      WordPress
	 * @package       SilvweWp
	 * @subpackage    Widget
	 * @copyright     SilverSite.pl (c) 2015
	 */
	class Social extends WidgetAbstract {
		public function __construct() {
			$this->setDefaultTitleLabel( Translate::translate( 'Social Widget' ) );
			// Configure widget array
			$widget_options = array(
				'description' => Translate::translate( 'Social icons with link to social accounts.' ),
			);
			parent::__construct(
				'silverwp-social',
				Translate::translate( 'SilverWp Social' ),
				$widget_options
			);
			// Configure the widget fields
			$title = new Text( 'title' );
			$title->setLabel( Translate::translate( 'Title' ) );
			$title->setDefault( Translate::translate( 'Social Widget' ) );
			$this->addControl( $title );

			$accounts = new Checkbox( 'accounts' );
			$accounts->setLabel( Translate::translate( 'Social accounts' ) );

			$options = array();
			$social_accounts = \SilverWp\Helper\Social::getIcons();
			foreach ( $social_accounts as $slug => $value ) {
				$options[] = array(
					'value' => $slug,
					'label' => $value['label']
				);
			}
			$accounts->setOptions( $options );
			$accounts->setMulti( true );
			$this->addControl( $accounts );

		}
	}
}