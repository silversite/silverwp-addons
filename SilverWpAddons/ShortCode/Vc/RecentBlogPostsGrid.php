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
/*
 Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/RecentBlogPostsGrid.php $
 Last committed: $Revision: 2356 $
 Last changed by: $Author: padalec $
 Last changed date: $Date: 2015-02-06 12:28:47 +0100 (Pt, 06 lut 2015) $
 ID: $Id: RecentBlogPostsGrid.php 2356 2015-02-06 11:28:47Z padalec $
*/
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\Helper\Post;
use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\Control\Slider;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\RecentBlogPostsGrid' ) ) {
    /**
     * Short Code Recent Blog Posts Grid
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Id: RecentBlogPostsGrid.php 2356 2015-02-06 11:28:47Z padalec $
     */
    class RecentBlogPostsGrid extends ShortCodeAbstract {
        protected $tag_base = 'ds_blog_grid';

        /**
         * Render Short Code content
         *
         * @param array  $args short code attributes
         * @param string $content content string added between short code tags
         *
         * @return mixed
         * @access public
         */
        public function content( $args, $content ) {
            $default = $this->prepareAttributes();

            $limit = isset( $args[ 'post_count' ] ) ? $args[ 'post_count' ] : 3;

            $thumbnail_size = $args[ 'thumbnail_size' ];
            if ( isset( $args[ 'thumbnail_size' ] ) && strpos( $args[ 'thumbnail_size' ], 'x' ) ) {
                $thumbnail_size = explode( 'x', $args[ 'thumbnail_size' ] );
            }

            $content = Post::getRecent( $limit, $thumbnail_size );

            $short_code_attributes = $this->setDefaultAttributeValue( $default, $args );
            $output                = $this->render( $short_code_attributes, $content );

            return $output;
        }

        /**
         * This method is used to build setting form element
         *
         * @return mixed
         * @access protected
         */
        protected function create() {
            $this->setLabel( Translate::translate( 'Recent blog posts grid' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
            $this->setIcon( 'icon-wpb-wp' );
            $this->setViewClassName( '\SilverWpAddons\ShortCode\View\RecentBlogPostGrid' );

            $post_count = new Slider( 'post_count' );
            $post_count->setLabel( Translate::translate( 'Post count' ) );
            $post_count->setMin( 1 );
            $post_count->setMax( 10 );
            $post_count->setStep( 1 );
            $post_count->setDefault( 3 );
            $this->addControl( $post_count );

            $column_count = new Select( 'column_count' );
            $column_count->setLabel( Translate::translate( 'Column count' ) );
            $column_count->setOptions( silverwp_get_column_count() );
            $this->addControl( $column_count );

            $thumbnail_size = new Text( 'thumbnail_size' );
            $thumbnail_size->setLabel( Translate::translate( 'Thumbnail size' ) );
            $thumbnail_size->setValue( 'post-thumbnail' );
            $thumbnail_size->setDescription(
                Translate::translate(
                    'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current
                    theme. Alternatively enter image size in pixels: 200x100 (Width x Height) .'
                )
            );
            $this->addControl( $thumbnail_size );

            $layout = new Select( 'layout' );
            $layout->setLabel( Translate::translate( 'Layout' ) );
            $layout->setValue(
                array(
                    Translate::translate( 'Mini' )     => 'mini',
                    Translate::translate( 'Standard' ) => 'standard'
                )
            );
            $layout->setDefault( 'standard' );
            $this->addControl( $layout );

            $line2 = new Select( 'line2' );
            $line2->setLabel( Translate::translate( 'Line 2 (below title)' ) );
            $line_select = array(
                ''                                        => '',
                Translate::translate( 'Category names' )  => 'category_names',
                Translate::translate( 'Author' )          => 'author',
                Translate::translate( 'Publish date' )    => 'date',
                Translate::translate( 'Comments number' ) => 'comments_number',
            );
            $line2->setValue( $line_select );
            $line2->setDependency( 'layout', array( 'mini' ) );
            $line2->setDefault( 'category_names' );
            $this->addControl( $line2 );

            $line3 = new Select( 'line3' );
            $line3->setLabel( Translate::translate( 'Line 3' ) );
            $line3->setValue( $line_select );
            $line3->setDefault( 'date' );
            $line3->setDependency( 'layout', array( 'mini' ) );
            $this->addControl( $line3 );

            $show_date = new Checkbox( 'show_date' );
            $show_date->setLabel( Translate::translate( 'Show date ?' ) );
            $show_date->setValue( array( Translate::translate( 'Yes, please' ) => 1 ) );
            $show_date->setDependency( 'layout', array( 'standard' ) );
            $this->addControl( $show_date );

            $show_category = new Checkbox( 'show_category' );
            $show_category->setLabel( Translate::translate( 'Show category ?' ) );
            $show_category->setValue( array( Translate::translate( 'Yes, please' ) => 1 ) );
            $show_category->setDependency( 'layout', array( 'standard' ) );
            $this->addControl( $show_category );

            $show_comments = new Checkbox( 'show_comments' );
            $show_comments->setLabel( Translate::translate( 'Show comments number ?' ) );
            $show_comments->setValue( array( Translate::translate( 'Yes, please' ) => 1 ) );
            $show_comments->setDependency( 'layout', array( 'standard' ) );
            $this->addControl( $show_comments );

            $show_author = new Checkbox( 'show_author' );
            $show_author->setLabel( Translate::translate( 'Show author ?' ) );
            $show_author->setValue( array( Translate::translate( 'Yes, please' ) => 1 ) );
            $show_author->setDependency( 'layout', array( 'standard' ) );
            $this->addControl( $show_author );

            $show_read_more = new Checkbox( 'show_read_more' );
            $show_read_more->setLabel( Translate::translate( 'Show read more link ?' ) );
            $show_read_more->setValue( array( Translate::translate( 'Yes, please' ) => 1 ) );
            $show_read_more->setDependency( 'layout', array( 'standard' ) );
            $this->addControl( $show_read_more );

            //field Extra class name (input text)
            $el_css = new ExtraCss();
            $this->addControl( $el_css );
        }
    }
}