<?php

/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
 *                    Marcin Dobroszek <marcin at silversite.pl>
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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/SilverWP/PSR2/wp-content/themes/silverwp/lib/SilverWpAddons/ShortCode/Generator/Menu/Tabs.php $
  Last committed: $Revision: 1555 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2014-09-30 21:38:38 +0200 (Wt, 30 wrz 2014) $
  ID: $Id: Tabs.php 1555 2014-09-30 19:38:38Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu;

use SilverWpAddons\ShortCode\Generator\Menu\Element;
use SilverWpAddons\Translate;

/**
 * Tabs menu generator in short code generator
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @author Marcin Dobroszek <marcin at silversite.pl>
 * @version $Id: Tabs.php 1555 2014-09-30 19:38:38Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage ShortCode\Generator\Menu
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class PostTypes extends MenuAbstract
{
    public function getTitle()
    {
        $title = Translate::translate('Post Types');
        return $title;
    }
    
    public function createMenuElement()
    {
        $this->addElement(Element\Portfolio::getInstance());
        $this->addElement(Element\Blog::getInstance());
        $this->addElement(Element\Service::getInstance());
        $this->addElement(Element\Team::getInstance());
        $this->addElement(Element\Timeline::getInstance());
        $this->addElement(Element\Testimonial::getInstance());
        $this->addElement(Element\PricePlan::getInstance());
        $this->addElement(Element\PieCharts::getInstance());
        $this->addElement(Element\CompanyStats::getInstance());
        $this->addElement(Element\Clients::getInstance());
        $this->addElement(Element\ColourfulBar::getInstance());
        //$this->addElement(Element\CompanyAdvantage::getInstance());
        //$this->addElement(Element\Features::getInstance());
        //$this->addElement(Element\Presentation::getInstance());
        //$this->addElement(Element\Video::getInstance());
        //$this->addElement(Element\Gallery::getInstance());
    }
}
