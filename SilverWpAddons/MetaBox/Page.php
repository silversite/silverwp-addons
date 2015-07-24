<?php
namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Group;
use SilverWp\Helper\Control\Notebox;
use SilverWp\Helper\Control\SidebarPosition;
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Helper\Control\Upload;
use SilverWp\Helper\Option;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Page' ) ) {
    /**
     * Meta box for Pages
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: Page.php 2563 2015-03-12 14:23:49Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage MetaBox
     * @copyright (c) SilverSite.pl 2015
     */
    class Page extends MetaBoxAbstract {
        protected $id = 'page';
        protected $post_type = array( 'page' );
        protected $exclude_columns = array( 'category', 'tag' );

        protected function createMetaBox() {
            /*
                $args            = array(
                    'hide_empty' => false,
                );
                //$slider_category = SliderPt::getInstance()->getTaxonomy()->getName( 'category' );

                $topbar_layouts = $this->data( 'silverwp_get_topbar_layout' );
                $topbar_default = array(
                    'default' => Option::get_theme_option( 'page_default_topbar_layout' )
                );
                $header_layout  = $this->data( 'silverwp_get_header_layout' );
                $header_default = array(
                    'default' => Option::get_theme_option( 'page_default_header_layout' )
                );
                $meta_box = array(
                    $this->radioImage(
                        'topbar_layout',
                        Translate::translate( 'Top bar layout' ),
                        $topbar_layouts,
                        $topbar_default
                    ),
                    $this->radioImage(
                        'header_layout',
                        Translate::translate( 'Header layout' ),
                        $header_layout,
                        $header_default
                    ),
                    $this->textarea(
                        'header_layout_image_text',
                        Translate::translate( 'Text in header' ),
                        null,
                        $this->dependency( 'silverwp_header_layout_image_dependency', 'header_layout' )
                    ),
                    $this->checkbox(
                        'header_layout_titlebar_breadcrumbs',
                        Translate::translate( 'Enable breadcrumbs?' ),
                        array(
                            array(
                                'label' => Translate::translate( 'Yes please' ),
                                'value' => 1,
                            )
                        ),
                        '{{first}}',
                        $this->dependency( 'silverwp_header_layout_titlebar_dependency', 'header_layout' )
                    ),
            );*/
            //page header group
            $header_group = new Group( 'header' );
            $header_group->setLabel( Translate::translate( 'Page header' ) );

            $title = new Text( 'title' );
            $title->setLabel( Translate::translate( 'Title' ) );
            $header_group->addControl( $title );

            $text = new Textarea( 'text' );
            $text->setLabel( Translate::translate( 'Text' ) );
            $header_group->addControl( $text );

            $bg_image = new Upload( 'background_image' );
            $bg_image->setLabel( Translate::translate( 'Background image' ) );
            $bg_image->setDefault( Option::get_theme_option( 'style_layout[page_background_image]' ) );
            $header_group->addControl( $bg_image );
            //END page header group
            $this->addMetaBox( $header_group );

            //content group
            $content_group = new Group( 'content' );
            $content_group->setLabel( Translate::translate( 'Texts and Short Codes' ) );

            $note = new Notebox( 'note' );
            $note->setLabel( Translate::translate( 'The following fields allow for setting content and shortcodes above and below the container. Thanks to this elment you can use full width of the screen.' ) );
            $content_group->addControl( $note );

            $above = new Textarea( 'above' );
            $above->setLabel( Translate::translate( 'Above the content' ) );
            $content_group->addControl( $above );

            $below = new Textarea( 'below' );
            $below->setLabel( Translate::translate( 'Below the content' ) );
            $content_group->addControl( $below );

            $this->addMetaBox( $content_group );
            //END content group

            $sidebar_group = new Group( 'sidebar' );
            $sidebar_group->setLabel( Translate::translate( 'Page sidebar' ) );
            $sidebar = new SidebarPosition('page_sidebar');
            $sidebar->setLabel(Translate::translate('Sidebar position'));
            $sidebar->removeOption(1);
            $sidebar_group->addControl($sidebar);
            $this->addMetaBox( $sidebar_group );
        }
    }
}