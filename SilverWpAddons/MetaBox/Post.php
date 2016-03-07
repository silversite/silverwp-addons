<?php

namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\PostFormat;
use SilverWp\Helper\Control\SidebarPosition;
use SilverWp\Helper\Control\Toggle;
use SilverWp\Helper\Option;
use SilverWp\MetaBox\MetaBoxAbstract;
use SilverWp\Translate;

if ( ! class_exists( 'SilverWpAddons\Post' ) ) {
	/**
	 *
	 * Meta box for Post
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       0.3
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Post extends MetaBoxAbstract {
		protected $id = 'post';
		protected $post_types = array( 'post' );
		protected $exclude_columns = array( 'category', 'tag' );

		protected function setUp() {
			$featured_list = new Toggle( 'featured' );
			$featured_list->setLabel( Translate::translate( 'Featured on the list' ) );
			$featured_list->setDefault( 0 );
			$this->addControl( $featured_list );

            $sidebar = new SidebarPosition( 'sidebar' );
            $sidebar->setLabel( Translate::translate( 'Sidebar position' ) );
            // $sidebar->removeOption( 1 ); // remove left sidebar option
            $sidebar->setDefault( Option::get_theme_option( 'blogposts_sidebar' ) );
            $this->addControl( $sidebar );

            $modify = new Toggle( 'modify' );
            $modify->setLabel( Translate::translate( 'Modified content' ) );
            $modify->setDescription( Translate::translate( 'Narrower text content. Recommended for no-sidebar view.' ) );
            $modify->setDefault( 0 );
            $this->addControl( $modify );

			$post_format = new PostFormat();
			$this->addControl( $post_format );

		}

		/**
		 * Remove meta box
		 *
		 * @return array
		 * @see    https://codex.wordpress.org/Function_Reference/remove_meta_box
		 * @access public
		 */
		public function remove() {
			return array(
				array(
					'id'      => 'formatdiv',
					'page'    => 'post',
					'context' => 'side',
				),
			);
		}
	}
}
