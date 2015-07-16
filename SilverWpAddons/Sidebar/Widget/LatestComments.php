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
/*
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/Sidebar/Widget/LatestComments.php $
  Last committed: $Revision: 2427 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-02-12 15:36:08 +0100 (Cz, 12 lut 2015) $
  ID: $Id: LatestComments.php 2427 2015-02-12 14:36:08Z padalec $
 */

namespace SilverWpAddons\Sidebar\Widget;

use SilverWpAddons\Translate;

/**
 * Latest comments
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Revision: 2427 $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage Sidebar\Widget
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class LatestComments extends WidgetAbstract {
    public function __construct() {
        // Configure widget array
        $args = array(
            'name'        => 'latest-comments',
            // Widget Backend label
            'label'       => Translate::translate( 'Latest comments' ),
            // Widget Backend Description
            'description' => Translate::translate( 'widget description.' ),
            'options'     => array(
                'classname' => 'widget_latest_comments_with_excerpts',
            )
        );
        // Configure the widget fields
        // Example for: Title ( text ) and Amount of posts to show ( select box )
        // fields array
        $args[ 'fields' ] = array(
            // Title field
            array(
                'name'     => Translate::translate( 'Title' ),
                'id'       => 'title',
                'type'     => 'text',
                'class'    => 'widefat',
                'validate' => 'alpha_numeric',
                'filter'   => 'strip_tags|esc_attr',
                'std'      => Translate::translate( 'Latest comments with excerpts' ),
            ),
            array(
                'name'     => Translate::translate( 'Number of comments to show' ),
                'id'       => 'limit',
                'type'     => 'number',
                'class'    => 'widefat',
                'std'      => 5,
                'validate' => 'numeric',
            )// add more fields
        ); // fields array
        // create widget
        $this->createWidget( $args );
    }

    public function widget( $args, $instance ) {
        $title = empty( $instance[ 'title' ] )
            ? Translate::translate( 'Latest comments with excerpts' )
            : $instance[ 'title' ];

        apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $comments_args = array(
            'orderby' => 'date',
            'order'   => 'DESC',
            'number'  => $instance['limit'],
        );

        $comments = get_comments( $comments_args );

        $comments_list = array();
        foreach ( $comments as $key => $comment ) {
            $comments_list[ $key ]                              = $comment;
            $comments_list[ $key ]->{'comment_content_excerpt'} = get_comment_excerpt( $comment->comment_ID );
            $comments_list[ $key ]->{'post_permalink'}          = get_post_permalink( $comment->comment_post_ID );
            $comments_list[ $key ]->{'post_title'}              = get_the_title( $comment->comment_post_ID );
        }

        $data = array(
            'comments_list' => $comments_list,
            'args'          => $args,
            'instance'      => $instance,
        );
        $this->render( $data );
    }
}
