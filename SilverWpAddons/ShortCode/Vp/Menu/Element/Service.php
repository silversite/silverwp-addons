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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/Service.php $
  Last committed: $Revision: 2057 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-09 16:07:01 +0100 (Pt, 09 sty 2015) $
  ID: $Id: Service.php 2057 2015-01-09 15:07:01Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Translate;

/**
 *
 * Service short code and menu elements
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: Service.php 2057 2015-01-09 15:07:01Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Service extends ElementAbstract {
    protected $name = 'services';
    protected $with_close_tag = false;

    public function createElements() {
        $items = array(
            array(
                'label' => Translate::translate( 'Top' ),
                'value' => 'top',
            ),
            array(
                'label' => Translate::translate( 'Left' ),
                'value' => 'left',
            )
        );

        $attributes = array(
            $this->text( 'title', Translate::translate( 'Box title' ) ),
            $this->textArea( 'description', Translate::translate( 'Box description' ) ),
            $this->slider(
                'count',
                Translate::translate( 'Maximum item in row' ),
                array(
                    'min'  => 2,
                    'max'  => 4,
                    'step' => 1
                )
            ),
            $this->radio( 'icoposition', Translate::translate( 'Icon position' ), $items, array() ),
            $this->toggle( 'icoborder', Translate::translate( 'Icon border' ) ),
        );
        $elements   = $this->addElement( Translate::translate( 'Services' ), $attributes );

        return $elements;
    }

    /**
     * Service short code render function
     *
     * @param array $args short code attributes
     *
     * @return string
     * @access public
     */
    public function shortCode( $args, $content ) {
        $Serives    = \SilverWpAddons\PostType\Service::getInstance();
        $limit      = isset( $args[ 'limit' ] ) ? $args[ 'limit' ] : 0;
        $query_data = $Serives->getQueryData( $limit );

        $data    = array(
            'args' => $args,
            'data' => $query_data,
        );
        $content = $this->render( $data );

        return $content;
    }
}
