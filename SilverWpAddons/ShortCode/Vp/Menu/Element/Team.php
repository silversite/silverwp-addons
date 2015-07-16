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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/Team.php $
  Last committed: $Revision: 2057 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-09 16:07:01 +0100 (Pt, 09 sty 2015) $
  ID: $Id: Team.php 2057 2015-01-09 15:07:01Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Translate;

/**
 * 
 * Tab nav item menu
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: Team.php 2057 2015-01-09 15:07:01Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage SilverWpAddons\ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Team extends ElementAbstract
{
    protected $name = 'team';
    protected $with_close_tag = false;
    
    public function createElements()
    {
        $attributes = array(
            $this->text('title', Translate::translate('Box title')),
            $this->textarea('description', Translate::translate('Box description')),
            $this->slider(
                'limit',
                Translate::translate('Number of person'),
                array(
                    'min'       => 1,
                    'max'       => 35,
                    'default'   => 4,
                    'step'      => 1
                )
            ),
            $this->radio(
                'layout',
                Translate::translate('Layout'),
                array(
                    array(
                        'label' => Translate::translate('Grid with images only'),
                        'value' => 'grig'
                    ),
                    array(
                        'label' => Translate::translate('List with description of members'),
                        'value' => 'list'
                    )
                )
            ),
        );
        $elements = $this->addElement(Translate::translate('Team'), $attributes);
        return $elements;
    }
    /**
     * Team
     *
     * @param array $args short code attributes
     * @return string
     */
    public function shortCode($args, $content)
    {
        $Team = \SilverWpAddons\PostType\Team::getInstance();
        $limit = isset($args['limit']) ? $args['limit'] : 4;
        $team_list = $Team->getQueryData($limit);
        $data = array(
            'args'      => $args,
            'data'      => $team_list,
        );
        $content = $this->render($data);
        return $content;
    }
}
