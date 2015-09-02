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
namespace SilverWpAddons\Widget;

use SilverWp\Debug;
use SilverWp\Helper\Control\Text;
use SilverWp\Translate;
use SilverWp\Widget\WidgetAbstract;
use SilverWp\Widget\WidgetInterface;

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
class Social extends WidgetAbstract implements WidgetInterface {
	protected $debug = false;
    public function __construct() {
		parent::__construct('social', Translate::translate('Social'));
	    $text = new Text( 'test' );
	    $text->setLabel( 'test' );
	    $this->addControl( $text );
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
