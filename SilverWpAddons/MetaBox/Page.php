<?php
namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Attachments;
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Helper\Control\Upload;
use SilverWp\Helper\Control\SidebarPosition;
//use SilverWp\Helper\Control\Gallery;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;
use SilverWp\Helper\Control\Group;

if ( ! class_exists( '\SilverWpAddons\Page' ) ) {
	/**
	 * Meta box for Pages
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id: Page.php 2563 2015-03-12 14:23:49Z padalec $
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Page extends MetaBoxAbstract {
		protected $id = 'page';
		protected $post_types = array( 'page' );
		protected $exclude_columns = array( 'category', 'tag' );

		protected function setUp() {

			$sidebar = new SidebarPosition( 'sidebar' );
			$sidebar->setLabel( Translate::translate( 'Sidebar position' ) );
			$sidebar->removeOption( 1 );
			$sidebar->setDefault( \SilverWp\get_theme_option( 'pages_sidebar' ) );
			$this->addControl( $sidebar );

			$header = new Group('pageheader');
			$header->setLabel(Translate::translate('Page header'));
			$header_title = new Text( 'pageheadertitle' );
			$header_title->setLabel( Translate::translate( 'Title' ) );
			$header->addControl( $header_title );
			$header_desc = new Textarea( 'pageheaderdescription' );
			$header_desc->setLabel( Translate::translate( 'Description' ) );
			$header->addControl( $header_desc );
			$header_bg = new Attachments( 'pageheaderbg' );
			$header_bg->setLabel( Translate::translate( 'Background image' ) );
			$header->addControl( $header_bg );
			$this->addControl( $header );
		}
	}
}