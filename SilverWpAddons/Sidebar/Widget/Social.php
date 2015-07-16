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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/Sidebar/Widget/Social.php $
  Last committed: $Revision: 2187 $
  Last changed by: $Author: cichy $
  Last changed date: $Date: 2015-01-21 14:44:21 +0100 (Śr, 21 sty 2015) $
  ID: $Id: Social.php 2187 2015-01-21 13:44:21Z cichy $
 */

namespace SilverWpAddons\Sidebar\Widget;

use SilverWpAddons\Translate;

/**
 * Social accounts list
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: Social.php 2187 2015-01-21 13:44:21Z cichy $
 * @category WordPress
 * @package SilvweWp
 * @subpackage Sidebar\Widget
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Social extends WidgetAbstract {
    public function __construct() {
        // Configure widget array
        $args             = array(
            // Widget Backend label
            'label'       => Translate::translate( 'Social accounts' ),
            'name'        => 'social',
            // Widget Backend Description
            'description' => Translate::translate( 'Social icons with link to social accounts. Configuration social accounts is available in Theme Options - social bookmark.' ),
            'options'     => array(
                'classname' => 'widget_social'
            )
        );
        $args[ 'fields' ] = array(
            // Title field
            array(
                'name'     => Translate::translate( 'Title' ),
                'id'       => 'title',
                'type'     => 'text',
                'class'    => 'widefat',
                'validate' => 'alpha_numeric',
                'filter'   => 'strip_tags|esc_attr',
                'std'      => Translate::translate( 'Social accounts' ),
            ),
            // Title field
            array(
                'name'     => Translate::translate( 'Description' ),
                'id'       => 'description',
                'type'     => 'textarea',
                'class'    => 'widefat',
                'validate' => 'alpha_numeric',
                //'filter'   => 'strip_tags|esc_attr',
                //'std'      => Translate::translate( 'Social accounts' ),
            ),
        );

        $this->createWidget( $args );
    }

    // Output function
    public function widget( $args, $instance ) {
        $accounts = \SilverWpAddons\Helper\Social::getAccounts();

        if ( ! isset( $accounts ) || count( $accounts ) === 0 ) {
            return; // no Social icon - empty widget
        }

        //widget <section>
        $out = $args[ 'before_widget' ];

        // widget title
        $out .= $args[ 'before_title' ];
        $out .= ( isset( $instance[ 'title' ] ) && $instance[ 'title' ] )
            ? $instance[ 'title' ] : Translate::translate( 'Social' );
        $out .= $args[ 'after_title' ] . "\n";

        if ( isset($instance['description']) && $instance['description'] !== '' ) {
            $out .= '<div class="text">'.$instance['description'].'</div>' . "\n";
        }

        foreach ( $accounts as $social_item ) {
            $out .=  '<a class="social-item" href="'.esc_url($social_item['url']).'" target="_blank" rel="nofollow" title="'.esc_attr($social_item['name']).'"><i class="'.esc_attr($social_item['icon']).'"></i></a>' . "\n";
        }

        //widget end </section>
        $out .= $args[ 'after_widget' ];

        echo $out;
    }
}
