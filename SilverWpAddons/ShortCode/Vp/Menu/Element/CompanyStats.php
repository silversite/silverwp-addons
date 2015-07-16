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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/CompanyStats.php $
  Last committed: $Revision: 2057 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-09 16:07:01 +0100 (Pt, 09 sty 2015) $
  ID: $Id: CompanyStats.php 2057 2015-01-09 15:07:01Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Translate;

/**
 * 
 * Tab nav item menu
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: CompanyStats.php 2057 2015-01-09 15:07:01Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class CompanyStats extends ElementAbstract
{
    protected $name = 'stats';
    protected $with_close_tag = false;
    
    public function createElements()
    {
        $colors = $this->data('vp_get_sc_company_bg_colours');
        
        $type_items = array(
            array(
                'value' => 'simple',
                'label' => Translate::translate('simple'),
            ),
            array(
                'value' => 'grid',
                'label' => Translate::translate('grid'),
            ),
        );
        
        $attributes = array(
            $this->text('title', Translate::translate('Box title')),
            $this->textarea('description', Translate::translate('Box description')),
            $this->fontklicon('ico', Translate::translate('Icon (under title)')),
            $this->radio('bgcolor', Translate::translate('Background colour'), $colors),
            $this->radio('type', Translate::translate('Type'), $type_items)
        );
        $elements = $this->addElement(Translate::translate('Company Stats'), $attributes);
        return $elements;
    }
    /**
     * CompanyAdvantage
     *
     * @param array $args short code attributes
     * @return string
     */
    public function shortCode($args, $content)
    {
        $CompanyAdvantage = \SilverWpAddons\PostType\CompanyStats::getInstance();
        $query_data = $CompanyAdvantage->getQueryData(0);
        $data = array(
            'args'      => $args,
            'data'      => $query_data,
        );
        $content = $this->render($data);
        return $content;
    }
}
