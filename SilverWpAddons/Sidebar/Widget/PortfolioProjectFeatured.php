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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/Sidebar/Widget/PortfolioProjectFeatured.php $
  Last committed: $Revision: 2184 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-21 13:20:08 +0100 (Śr, 21 sty 2015) $
  ID: $Id: PortfolioProjectFeatured.php 2184 2015-01-21 12:20:08Z padalec $
 */

namespace SilverWpAddons\Sidebar\Widget;

use SilverWpAddons\PostType\Portfolio;
use SilverWpAddons\Translate;

/**
 * Portfolio Project Details Widget
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: PortfolioProjectFeatured.php 2184 2015-01-21 12:20:08Z padalec $
 * @category WordPress
 * @package Sidebar
 * @subpackage Widget
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */

class PortfolioProjectFeatured extends WidgetAbstract
{
    public function __construct()
    {
        // Configure widget array
        $args = array(
            // Widget Backend label
            'label'         => Translate::translate('Portfolio Project Features'),
            'name'          => 'portfolio_project_featured',
            // Widget Backend Description
            'description'   => Translate::translate('Enabled only on single Project view with sidebar.'),
            'options'       => array (
                'classname'  => 'widget_portfolio_project_features'
            )
        );
        $args['fields'] = array(
            // Title field
            array(
                'name'      => Translate::translate('Title'),
                'id'        => 'title',
                'type'      => 'text',
                'class'     => 'widefat',
                'validate'  => 'alpha_numeric',
                'filter'    => 'strip_tags|esc_attr',
                'std'       => Translate::translate('Features'),
            ),
        );
        $this->createWidget($args);
    }

    // Output function
    public function widget($args, $instance)
    {
        $Portfolio = Portfolio::getInstance();
        if (is_single() && get_post_type() === $Portfolio->getName()) {

            // format output data
            $features = $Portfolio->getMetaBox()->getFeatures(\get_the_ID());

            if (count($features) === 0) {
                return; // project without Features - widget will not be visible
            }
            //widget <section>
            $out = $args['before_widget'];

            // title H3
            $out .= $args['before_title'];
            $out .= (isset($instance['title']) && $instance['title'])
                        ? $instance['title'] : Translate::translate('Features');
            $out .= $args['after_title'];

            $out .= '<ul>' . "\n";
            foreach ($features as $feature) {
                $out .= '<li><i class="klico-check"></i> '. $feature['name'] .'</li>' . "\n";
            }
            $out .= '</ul>' . "\n";
            //widget end </section>
            $out .= $args['after_widget'];
            echo $out;
        }
    }
}
