<?php

namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Group;
//use SilverWp\Helper\Control\Gallery;
use SilverWp\Helper\Control\SidebarPosition;
use SilverWp\Helper\Control\Toggle;
use SilverWp\Helper\Option;
use SilverWp\MetaBox\MetaBoxAbstract;
use SilverWp\Translate;

if ( ! class_exists( 'SilverWpAddons\Blog' ) ) {
	/**
	 *
	 * Meta box for Blog
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       0.3
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Blog extends MetaBoxAbstract {
		protected $id = 'post';
		protected $post_types = array( 'post' );
		protected $exclude_columns = array( 'category', 'tag' );

		protected function setUp() {

            $sidebar = new SidebarPosition( 'sidebar' );
            $sidebar->setLabel( Translate::translate( 'Sidebar position' ) );
            $sidebar->removeOption( 1 );
            $sidebar->setDefault( Option::get_theme_option( 'blogposts_sidebar' ) );
            $this->addControl( $sidebar );

            $groupSource = new Group( 'source' );
			$groupSource->setRepeating( true );
			$groupSource->setSortable( true );
            $groupSource->setLabel( Translate::translate( 'Source' ) );
            $sourceName = new Text( 'source_name' );
            $sourceName->setLabel( Translate::translate( 'Name' ) );
            $groupSource->addControl( $sourceName );
            $sourceUrl = new Text( 'source_url' );
            $sourceUrl->setLabel( Translate::translate( 'Address URL' ) );
            $sourceUrl->setValidation( 'url' );
            $groupSource->addControl( $sourceUrl );
            $sourceAlt = new Text( 'source_alt' );
            $sourceAlt->setLabel( Translate::translate( 'Original title' ) );
            $groupSource->addControl( $sourceAlt );
            $this->addControl( $groupSource );

			$groupMore = new Group( 'more' );
			$groupMore->setRepeating( true );
			$groupMore->setSortable( true );
			$groupMore->setLabel( Translate::translate( 'More' ) );
			$sourceName = new Text( 'more_name' );
			$sourceName->setLabel( Translate::translate( 'Name' ) );
			$groupMore->addControl( $sourceName );
			$sourceUrl = new Text( 'more_url' );
			$sourceUrl->setLabel( Translate::translate( 'Address URL' ) );
			$sourceUrl->setValidation( 'url' );
			$groupMore->addControl( $sourceUrl );
			$sourceAlt = new Text( 'more_alt' );
			$sourceAlt->setLabel( Translate::translate( 'Original title' ) );
			$groupMore->addControl( $sourceAlt );
			$this->addControl( $groupMore );

            $groupVideo = new Group( 'video' );
            $groupVideo->setLabel( Translate::translate( 'Video' ) );
            $url = new Text( 'url' );
            $url->setLabel( Translate::translate( 'YouTube or Vimeo file URL' ) );
            $url->setValidation( 'url' );
            $groupVideo->addControl( $url );
            $this->addControl( $groupVideo );

            $groupRelated = new Group( 'related' );
            $groupRelated->setRepeating( true );
            $groupRelated->setSortable( true );
            $groupRelated->setLabel( Translate::translate( 'Related Posts' ) );
            $relatedId = new Text( 'related_id' );
            $relatedId->setLabel( Translate::translate( 'Post ID' ) );
            $groupRelated->addControl( $relatedId );
            $this->addControl( $groupRelated );
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
