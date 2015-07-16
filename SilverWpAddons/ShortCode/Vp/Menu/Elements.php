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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Generator/Menu/Elements.php $
  Last committed: $Revision: 1891 $
  Last changed by: $Author: cichy $
  Last changed date: $Date: 2014-12-05 13:16:18 +0100 (Pt, 05 gru 2014) $
  ID: $Id: Elements.php 1891 2014-12-05 12:16:18Z cichy $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu;

use SilverWpAddons\ShortCode\Generator\Menu\Element;
use SilverWpAddons\Translate;

/**
 * Elements menu generator in short code generator
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: Elements.php 1891 2014-12-05 12:16:18Z cichy $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage ShortCode\Generator\Menu
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Elements extends MenuAbstract
{
    public function getTitle()
    {
        $title = Translate::translate('Elements');
        return $title;
    }

    public function createMenuElement()
    {
        $this->addElement(Element\Button::getInstance());
        //$this->addElement(Element\KlIcons::getInstance());
        $this->addElement(Element\Icons::getInstance());
        //$this->addElement(Element\Gwf::getInstance());
        $this->addElement(Element\Social::getInstance());
        $this->addElement(Element\ProgressBar::getInstance());
        $this->addElement(Element\Highlight::getInstance());
        $this->addElement(Element\Dropcaps::getInstance());
        $this->addElement(Element\GoogleMap::getInstance());
	    $this->addElement(Element\Box::getInstance());
    }
}
