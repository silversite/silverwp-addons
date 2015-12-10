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
use SilverWp\ShortCode\Vc\Control\Text;
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
			$this->setCategory( Translate::translate( 'Add by Silversite.pl' ) );
            $this->setDescription( Translate::translate( 'Customizable list of Blogposts' ) );
			$this->setIcon( 'icon-wpb-application-icon-large' );

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
            $select->setAdminLabel( true );
			$this->addControl( $select );

			$checkbox = new Checkbox( 'hide_sticky_posts' );
			$checkbox->setLabel( Translate::translate( 'Hide Sticky Posts' ) );
			$checkbox->setDescription( Translate::translate( 'If YES - list ignores that a post is sticky and shows the posts in the normal order.' ) );
			$this->addControl( $checkbox );

            $category = new Select( 'category' );
			$category->setLabel( Translate::translate( 'Category' ) );
			$category->setDescription( Translate::translate( 'Set it if you want to show posts from one category only.' ) );

			$categories = get_categories();
			$category->addOption( 0, Translate::translate( 'all' ) );
			foreach ( $categories as $value ) {
				$category->addOption( $value->cat_ID, $value->name );
			}
			$this->addControl( $category );

            $text = new Text( 'limit' );
            $text->setLabel( Translate::translate( 'Limit' ) );
            $text->setDescription( Translate::translate( 'Maximum number of posts to show on a page.' ) );
            $text->setValue( get_option( 'posts_per_page', 10 ) );
            $this->addControl( $text );

			$animation = new Animation();
			$this->addControl( $animation );

			$extra_css = new ExtraCss();
			$this->addControl( $extra_css );
		}
	}
}
