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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/Button.php $
  Last committed: $Revision: 2057 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-09 16:07:01 +0100 (Pt, 09 sty 2015) $
  ID: $Id: Button.php 2057 2015-01-09 15:07:01Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Translate;

/**
 * Button short code and menu element in generator
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: Button.php 2057 2015-01-09 15:07:01Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Button extends ElementAbstract
{
    protected $name = 'button';
    protected $with_close_tag = false;
    
    public function createElements()
    {
        $rounding_items = array(
            array(
                'value' => 'normal',
                'label' => Translate::translate('Normal')
            ),
            array(
                'value' => 'strong',
                'label' => Translate::translate('Strong')
            ),
        );

        $colors = $this->data('vp_get_sc_button_colours');
        $size = $this->data('vp_get_sc_button_size');
        
        $attributes = array(
            $this->text('text', Translate::translate('Text')),
            $this->url('url', Translate::translate('URL')),
            $this->radio('size', Translate::translate('Size'), $size),
            $this->radio('rounding', Translate::translate('Rounding'), $rounding_items),
            $this->radio('accent', Translate::translate('Colour (background)'), $colors),
            $this->fontawesome('icon_after_text', Translate::translate('Icon after text')),
            $this->fontawesome('icon_before_text', Translate::translate('Icon before text')),
        );
        $elements = $this->addElement(Translate::translate('Button'), $attributes);
        return $elements;
    }
    
    public function shortCode($args, $content)
    {
        $data = array(
            'args'      => $args,
            'content'   => $content
        );
        $content = $this->render($data);
        return $content;
    }
}
