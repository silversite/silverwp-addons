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

			$beyond_content = new Group( 'beyond_content' );
			$beyond_content->setLabel( Translate::translate( 'Beyond the content' ) );

			$note = new Notebox( 'note' );
			$note->setLabel( Translate::translate( 'Thanks to this option you can set addon above the main container with content and sidebar.' ) );
			$beyond_content->addControl( $note );

			$above_content = new Select( 'above_content' );
			$above_content->setLabel( Translate::translate( 'Above the content' ) );
			$above_content->setOptions( array(
				array(
					'label' => Translate::translate( 'Empty' ),
					'value' => 'empty',
				),
				array(
					'label' => Translate::translate( 'Sticky posts, layout: Masonry GRID (4 posts)' ),
					'value' => 'sticky_post_masonry_grid',
				),
                array(
                    'label' => Translate::translate( 'Sticky posts, layout: Masonry GRID (3 posts)' ),
                    'value' => 'sticky_post_masonry_grid_alt',
                ),
				array(
					'label' => Translate::translate( 'Sticky posts, layout: Slider in container' ),
					'value' => 'sticky_post_slider_container',
				),
				array(
					'label' => Translate::translate( 'Sticky posts, layout: Slider on fullwidth screen' ),
					'value' => 'sticky_post_slider_fullwidth',
				),
			) );
			$above_content->setDefault( 'empty' );
			$beyond_content->addControl( $above_content );

            $button = new Checkbox( 'slider_button' );
            $button->setLabel( Translate::translate( 'Show button link in Slider' ) );
            $button->addOption( '1', Translate::translate( 'yes' ) );
            $beyond_content->addControl( $button );

			$this->addControl( $beyond_content );

			$social = new Group( 'social' );
			$social->setLabel( Translate::translate( 'Social plugin' ) );

			$social_plugin = new Select( 'social_plugin_position' );
			$social_plugin->setLabel( Translate::translate( 'Plugin position' ) );
			$social_plugin->setOptions( array(
				array(
					'label' => Translate::translate( 'No social plugin' ),
					'value' => 'no',
				),
				array(
					'label' => Translate::translate( 'Right-hand side of the content' ),
					'value' => 'right',
				),
				array(
					'label' => Translate::translate( 'Left-hand side of the screen' ),
					'value' => 'left',
				),
			) );

			if ( $pagenow == 'post-new.php' ) {
				$social_plugin->setDefault( Option::get_theme_option( 'social_plugin_position' ) );
			}
			$social_plugin->setValidation( 'required' );
			//$screen = \get_current_screen();
			$social->addControl( $social_plugin );

			$this->addControl( $social );
		}
	}
}