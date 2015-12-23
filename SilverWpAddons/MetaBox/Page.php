<?php
namespace SilverWpAddons\MetaBox;

use SilverWp\Debug;
use SilverWp\Helper\Control\Toggle;
use SilverWp\Helper\Control\Group;
use SilverWp\Helper\Control\Notebox;
use SilverWp\Helper\Control\Select;
use SilverWp\Helper\Control\SidebarPosition;
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Checkbox;
use SilverWp\Helper\Option;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

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
			global $pagenow;
			$sidebar = new SidebarPosition( 'sidebar' );
			$sidebar->setLabel( Translate::translate( 'Sidebar position' ) );
			$sidebar->removeOption( 1 );
			$sidebar->setDefault( Option::get_theme_option( 'pages_sidebar' ) );
			$this->addControl( $sidebar );

			$page_header = new Group( 'page_header' );
			$page_header->setLabel( Translate::translate( 'Page header' ) );

			$show_header = new Toggle( 'show_header' );
			$show_header->setLabel( Translate::translate( 'Show header' ) );
			$show_header->setDefault( '1' );
			$page_header->addControl( $show_header );

			$title = new Text( 'title' );
			$title->setLabel( Translate::translate( 'Title' ) );
			$title->setDependency( $show_header, 'vp_dep_boolean' );
			$page_header->addControl( $title );

			$subtitle = new Text( 'subtitle' );
			$subtitle->setLabel( Translate::translate( 'Subtitle' ) );
			$subtitle->setDependency( $show_header, 'vp_dep_boolean' );
			$page_header->addControl( $subtitle );
			$this->addControl( $page_header );
		}
	}
}