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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/Portfolio.php $
  Last committed: $Revision: 2057 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-09 16:07:01 +0100 (Pt, 09 sty 2015) $
  ID: $Id: Portfolio.php 2057 2015-01-09 15:07:01Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Translate;

/**
 *
 * Portfolio short code and menu elements
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: Portfolio.php 2057 2015-01-09 15:07:01Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Portfolio extends ElementAbstract
{
    protected $name = 'projects';
    protected $with_close_tag = false;

    public function createElements()
    {
        $layout = $items = array(
            array(
                'value' => 'grid',
                'label' => Translate::translate('grid'),
            ),
            array(
                'value' => 'carousel',
                'label' => Translate::translate('carousel'),
            ),
        );
        $attributes = array(
            $this->text('title', Translate::translate('Box title')),
            $this->textarea('description', Translate::translate('Box description')),
            $this->slider(
                'limit',
                Translate::translate('Number of projects'),
                array(
                    'min'       => 12,
                    'max'       => 30,
                    'default'   => 12,
                    'step'      => 6
                )
            ),
            $this->radio('layout', Translate::translate('Layout'), $layout),
        );
        $elements = $this->addElement(Translate::translate('Portfolio - latest projects'), $attributes);
        return $elements;
    }
    /**
     * Portfolio short code render function
     *
     * @param array $args short code attributes
     * @return string
     * @access public
     */
    public function shortCode($args, $content)
    {
        $Piecharts = \SilverWpAddons\PostType\Portfolio::getInstance();
        $query_data = $Piecharts->getQueryData($args['limit']);

        $data = array(
            'args'   => $args,
            'data'   => $query_data,
        );
        $content = $this->render($data);
        return $content;
    }
}
