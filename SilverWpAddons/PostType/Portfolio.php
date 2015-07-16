<?php
/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace SilverWpAddons\PostType;

use SilverWp\Helper\RecursiveArray;
use SilverWp\PostType\PostTypeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\Portfolio' ) ) {
    /**
     * Portfolio custom post type
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: Portfolio.php 2184 2015-01-21 12:20:08Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage PostType
     * @copyright (c) SilverSite.pl 2015
     */
    class Portfolio extends PostTypeAbstract {
        protected $name = 'portfolio';
        protected $supports = array( 'title', 'editor', 'thumbnail', 'comments' );

        protected function setLabels() {
            $this->labels = array(
                'menu_name'      => Translate::translate( 'Portfolio' ),
                'name'           => Translate::translate( 'Portfolio Projects' ),
                'name_admin_bar' => Translate::translate( 'Portfolio' ),
                'all_items'      => Translate::translate( 'All Portfolio' )
            );
        }

        /**
         *
         * list of related projects to directed posts
         *
         * @param int $post_id post id
         * @param int $limit limit of posts
         *
         * @return array list of related posts
         */
        public function getRelatedProjects( $post_id, $limit = 4 ) {
            $args = array(
                'tax_query'           => array(
                    'relation' => 'OR',
                    $this->getTagArgs( $post_id ),
                    $this->getCategoryArgs( $post_id ),
                ),
                'post_type'           => $this->getName(),
                'post__not_in'        => array( $post_id ),
                'posts_per_page'      => $limit,
                'ignore_sticky_posts' => 1
            );

            $posts        = $this->getQueryData( $limit, false, $args );
            $posts_counts = \count( $posts );
            if ( $posts_counts ) {

                if ( $limit > $posts_counts ) {
                    $related_id   = RecursiveArray::searchIterator( $posts, 'ID' );
                    $random_limit = $limit - $posts_counts;
                    $random_posts = $this->getRandomPosts( $random_limit,
                                                           \array_merge( array( $post_id ), $related_id ) );
                    $posts        = \array_merge( $posts, $random_posts );
                }
            }

            return $posts;
        }

        /**
         * get random posts
         *
         * @param int   $limit post display limit
         * @param array $exclude posts id should by exclude from results
         *
         * @return array
         */
        public function getRandomPosts( $limit = 4, array $exclude = array() ) {
            $args = array(
                'post_type'           => $this->getName(),
                'posts_per_page'      => $limit,
                'ignore_sticky_posts' => 1,
                'orderby'             => 'rand',
            );

            if ( count( $exclude ) ) {
                $args[ 'post__not_in' ] = $exclude;
            }
            $posts = $this->getQueryData( $limit, false, $args );

            return $posts;
        }

        /**
         *
         * format query args for tag taxonomy
         *
         * @param int $post_id post id
         *
         * @return array formate array passed to wp query args
         */
        private function getTagArgs( $post_id ) {
            $tax_data = null;

            $tax_name = $this->getTaxonomy()->getName( 'tag' );

            $tags = \wp_get_post_terms( $post_id, $tax_name );

            if ( \count( $tags ) ) {
                $tag_ids = array();
                foreach ( $tags as $individual_tax ) {
                    $tag_ids[ ] = $individual_tax->term_id;
                }

                $tax_data = array(
                    'taxonomy' => $tax_name,
                    'terms'    => $tag_ids,
                    'operator' => 'IN',
                    'field'    => 'term_id',
                );
            }

            return $tax_data;
        }

        /**
         *
         * format query args for categorry taxonomy
         *
         * @param int $post_id post id
         *
         * @return array formate array passed to wp query args
         */
        private function getCategoryArgs( $post_id ) {
            $tax_data = null;

            $tax_name = $this->getTaxonomy()->getName( 'category' );

            $cats = \wp_get_post_terms( $post_id, $tax_name );

            if ( \count( $cats ) ) {
                $cat_ids = array();
                foreach ( $cats as $individual_tax ) {
                    $cat_ids[ ] = $individual_tax->term_id;
                }

                if ( \count( $cat_ids ) ) {
                    $tax_data = array(
                        'taxonomy' => $tax_name,
                        'terms'    => $cat_ids,
                        'operator' => 'IN',
                        'field'    => 'term_id',
                    );
                }
            }

            return $tax_data;
        }
    }
}
