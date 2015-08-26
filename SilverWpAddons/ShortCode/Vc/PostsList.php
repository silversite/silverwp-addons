<?php
/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
 *
 * SilverWpAddons is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * SilverWpAddons is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\Debug;
use SilverWp\ShortCode\Vc\Control\Animation;
use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;
use SilverWpAddons\Ajax\BlogPosts;

if ( ! class_exists( '\SilverWpAddons\ShortCode\PostsList' ) ) {
	/**
	 * Short Code PostList
	 *
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    ShortCode
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @copyright (c) SilverSite.pl 2015
	 * @version       $Revision:$
	 */
	class PostsList extends ShortCodeAbstract {
		protected $tag_base = 'ss_postlist';
		public function __construct() {
			parent::__construct();
			//Ajax post list
			//todo move this to some extra property
			BlogPosts::getInstance();
		}

		/**
		 * Render Short Code content
		 *
		 * @param array  $args    short code attributes
		 * @param string $content content string added between short code tags
		 *
		 * @return string
		 * @access public
		 */
		public function content( $args, $content ) {

			$default    = $this->prepareAttributes();
			$attributes = $this->setDefaultAttributeValue( $default, $args );

			$this->addQueryArg( 'post_type', 'post' );
			$this->addQueryArg( 'ignore_sticky_posts', (boolean) $attributes[ 'hide_sticky_posts' ] );

			$output = $this->render( $attributes, $content );

			return $output;
		}

		/**
		 * Create short code settings
		 *
		 * @access public
		 * @return void
		 */
		protected function create() {
			$this->setLabel( Translate::translate( 'Posts list' ) );
			$this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
			$this->setIcon( 'icon-wpb-ui-posts-list' );

			$select = new Select( 'layout' );
			$select->setLabel( Translate::translate( 'Layout' ) );
			$select->setOptions(
				array(
					array(
						'label' => Translate::translate( 'list view' ),
						'value' => 'list',
					),
					array(
						'label' => Translate::translate( 'grid (1 column)' ),
						'value' => 'grid1',
					),
					array(
						'label' => Translate::translate( 'grid (2 column)' ),
						'value' => 'grid2',
					),
					array(
						'label' => Translate::translate( 'grid (3 column) - recommended only if you do not use Sidebar' ),
						'value' => 'grid3',
					)
				)
			);
			$select->setDefault( 'list' );
			$this->addControl( $select );

			$checkbox = new Checkbox( 'hide_sticky_posts' );
			$checkbox->setLabel( Translate::translate( 'Hide Sticky Posts' ) );
			$checkbox->setDescription( Translate::translate( 'If YES - list ignores that a post is sticky and shows the posts in the normal order.' ) );
			$this->addControl( $checkbox );

			$animation = new Animation();
			$this->addControl( $animation );

			$extra_css = new ExtraCss();
			$this->addControl( $extra_css );
		}
	}
}
