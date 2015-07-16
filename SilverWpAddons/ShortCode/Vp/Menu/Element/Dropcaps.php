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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/mango/wp-content/themes/silverwp/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/ProgressBar.php $
  Last committed: $Revision: 1632 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2014-10-06 19:52:06 +0200 (Pn, 06 paź 2014) $
  ID: $Id: ProgressBar.php 1632 2014-10-06 17:52:06Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Translate;

/**
 * 
 * Dropcaps short code
 *
 * @author Marcin Dobroszek <marcin at silversite.pl>
 * @version $Id: Highlight.php 1632 2014-10-06 17:52:06Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Dropcaps extends ElementAbstract
{
    protected $name = 'letter';
    protected $with_close_tag = true;
    
    public function createElements()
    {
        $colors = $this->data('silverwp_get_sc_dropcaps_color');
        $attributes = array(
            $this->radio('color', Translate::translate('Colour'), $colors),
        );
        $elements = $this->addElement(Translate::translate('Dropcap'), $attributes);
        return $elements;
    }
    /**
     * label short code render function
     *
     * @param array $args short code attributes
     * @return string
     * @access public
     */
    public function shortCode($args, $content)
    {
        $data = array(
            'args'      => $args,
            'content'   => $content,
        );
        $content = $this->render($data);
        return $content;
    }
}
