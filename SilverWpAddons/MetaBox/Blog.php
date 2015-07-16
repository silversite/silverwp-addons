<?php

namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Gallery;
use SilverWp\Helper\Control\Group;
use SilverWp\Helper\Control\SidebarPosition;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Helper\Option;
use SilverWp\MetaBox\MetaBoxAbstract;
use SilverWp\Helper\Control\Text;
use SilverWp\Translate;

if ( ! class_exists( 'SilverWpAddons\Blog' ) ) {
    /**
     *
     * Meta box for Blog
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: Blog.php 2559 2015-03-12 13:01:04Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage MetaBox
     * @copyright (c) SilverSite.pl 2015
     */
    class Blog extends MetaBoxAbstract {
        protected $id = 'post';
        protected $post_type = array( 'post' );
        protected $exclude_columns = array( 'category', 'tag' );

        protected function createMetaBox() {

            $sidebar = new SidebarPosition( 'sidebar' );
            $sidebar->setLabel( Translate::translate( 'Blog sidebar' ) )
                    ->setDefault( Option::get_theme_option( 'style_layout[blog_sidebar]' ) );
            $this->addMetaBox( $sidebar );

            //post format group
            $post_format_group = new Group( 'post_format' );
            $post_format_group->setLabel( Translate::translate( 'Post format' ) );
            //post format link group
            $link_group = new Group( 'link' );
            $link_group->setLabel( Translate::translate( 'Link' ) );

            $post_format_link = new Text( 'post_format_link' );
            $post_format_link
                ->setLabel( Translate::translate( 'Url' ) )
                ->setValidation( 'url' );

            $link_group->addControl( $post_format_link );
            //END post format link group
            $post_format_group->addControl( $link_group );

            //post format quote group
            $quote_group = new Group( 'quote' );
            $quote_group->setLabel( Translate::translate( 'Quote' ) );

            $quote_author = new Text( 'post_format_quote_author' );
            $quote_author->setLabel( Translate::translate( 'Author' ) );
            $quote_group->addControl( $quote_author );

            $quote_text = new Textarea( 'post_format_quote_text' );
            $quote_text->setLabel( Translate::translate( 'Text' ) );
            $quote_group->addControl( $quote_text );
            //END post format quote group
            $post_format_group->addControl( $quote_group );

            //post format video group
            $video_group = new Group( 'video' );
            $video_group->setLabel( Translate::translate( 'Video' ) );

            $url_video = new Text( 'video_url' );
            $url_video
                ->setLabel( Translate::translate( 'YouTube or Vimeo film URL' ) )
                ->setValidation( 'url' );
            $video_group->addControl( $url_video );
            //END post format video group
            $post_format_group->addControl( $video_group );

            //post format gallery group
            $gallery_group = new Gallery( 'post_format_gallery' );
            $post_format_group->addControl( $gallery_group );
            //END post format gallery group

            $this->addMetaBox( $post_format_group );
            //END post format group
        }
    }
}
