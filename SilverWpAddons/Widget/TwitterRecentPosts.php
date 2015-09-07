<?php
/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
 *                    Marcin Dobroszek <marcin at silversite.pl>
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

use SilverWp\Helper\Control\Slider;
use SilverWp\Helper\Control\Text;
use SilverWp\Translate;
use SilverWp\Widget\WidgetAbstract;

if ( ! class_exists( 'SilverWpAddons\Widget\TwitterRecentPosts' ) ) {
	/**
	 * Twitter - Recent Posts (latests tweets)
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @author        Marcin Dobroszek <marcin at silversite.pl>
	 * @version       $Id: TwitterRecentPosts.php 1895 2014-12-05 14:10:19Z cichy $
	 * @category      WordPress
	 * @package       SilverWp
	 * @subpackage    Sidebar\Widget
	 * @copyright (c) 2009 - 2014, SilverSite.pl
	 */
	class TwitterRecentPosts extends WidgetAbstract {

		public function __construct() {
			$widget_options = array(
				'description' => Translate::translate( 'Recent posts from Twitter social platform. Account data must be configured in Theme Options &rsaquo; Social.' ),
			);
			parent::__construct( 'twitter-recent-posts', 'Twitter', $widget_options );

			// Configure widget form
			$title = new Text( 'title' );
			$title->setLabel( Translate::translate( 'Title' ) );
			$title->setDefault( Translate::translate( 'Latest Tweets' ) );
			$this->addControl( $title );

			$limit = new Text( 'limit' );
			$limit->setLabel( Translate::translate( 'Number of posts to show' ) );
			/*$limit->setMin( 1 );
			$limit->setMax( 10 );
			$limit->setStep( 1 );*/
			$limit->setDefault( 3 );
			$this->addControl( $limit );
		}
	}
}
