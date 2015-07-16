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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/SilverWP/PSR2/wp-content/themes/silverwp/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/KlIcons.php $
  Last committed: $Revision: 1557 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2014-10-01 00:37:34 +0200 (Śr, 01 paź 2014) $
  ID: $Id: KlIcons.php 1557 2014-09-30 22:37:34Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Translate;

/**
 * 
 * KlIcons menu
 *
 * @author Marcin Dobroszek <marcin at silversite.pl>
 * @version $Id: Icons.php 1557 2014-09-30 22:37:34Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage SilverWpAddons\ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Icons extends ElementAbstract
{
    protected $name = 'icon';
    protected $with_close_tag = false;
    
    public function createElements()
    {
        $colors = $this->data('vp_get_sc_klicon_colours');
        $attributes = array(
            $this->fontello('name', Translate::translate('Name')),
            $this->radio('color', Translate::translate('Colour'), $colors),
        );
        $elements = $this->addElement(Translate::translate('Icon'), $attributes);
        return $elements;
    }
    /**
     * Client
     *
     * @param array $args short code attributes
     * @return string
     */
    public function shortCode($args, $content)
    {
        $data = array(
            'args'  => $args,
        );
        $content = $this->render($data);
        return $content;
    }
}
