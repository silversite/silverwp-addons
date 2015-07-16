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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/GoogleMap.php $
  Last committed: $Revision: 2086 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-14 17:50:59 +0100 (Śr, 14 sty 2015) $
  ID: $Id: GoogleMap.php 2086 2015-01-14 16:50:59Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Helper\Option;
use SilverWpAddons\Translate;

/**
 *
 * GoogleMap item menu
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: GoogleMap.php 2086 2015-01-14 16:50:59Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage SilverWpAddons\ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class GoogleMap extends ElementAbstract
{
    protected $name = 'gmap';
    protected $with_close_tag = false;
    
    public function createElements()
    {
        $attributes = array(
            $this->select(
                'type',
                Translate::translate('Map type'),
                $this->data('silverwp_get_map_type')
            ),
            $this->number(
                'latitude',
                Translate::translate('Point coordinates latitude'),
                null,
                Translate::translate('You can define coordinates using this <a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">tool</a>.')
            ),
            $this->number(
                'longitude',
                Translate::translate('Point coordinates longitude'),
                null,
                Translate::translate('You can define coordinates using this <a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">tool</a>.')
            ),
            $this->slider(
                'zoom',
                Translate::translate('Zoom'),
                array(
                    'min'        => 0,
                    'max'        => 19,
                    'step'       => 1,
                    'default'    => 0,
                )
            ),
        );
        $elements = $this->addElement(Translate::translate('Google Map'), $attributes);
        return $elements;
    }
    /**
     * gmap content item short code replace method
     *
     * @link http://getbootstrap.com/javascript/#collapse
     * @param array $args short code attributes
     * @param string $content content
     * @return string
     * @access public
     */
    public function shortCode($args, $content)
    {
        if (!isset($args['map_type'])) {
            $args['type'] = Option::get_theme_option('google_map_type');
        }
        
        if (!isset($args['latitude'])) {
            $args['latitude'] = Option::get_theme_option('google_map_point_coordinate_latitude');
        }
        
        if (!isset($args['longitude'])) {
            $args['longitude'] = Option::get_theme_option('google_map_point_coordinate_longitude');
        }
        
        if (!isset($args['zoom'])) {
            $args['zoom'] = Option::get_theme_option('google_map_marker_coordinate_zoom');
        }
        
        $data = array(
            'args' => $args,
        );
        $content = $this->render($data);
        return $content;
    }
}
