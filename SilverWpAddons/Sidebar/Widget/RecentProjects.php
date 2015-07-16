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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/Sidebar/Widget/RecentProjects.php $
  Last committed: $Revision: 2184 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-21 13:20:08 +0100 (Śr, 21 sty 2015) $
  ID: $Id: RecentProjects.php 2184 2015-01-21 12:20:08Z padalec $
 */

namespace SilverWpAddons\Sidebar\Widget;

use SilverWpAddons\PostType\Portfolio;
use SilverWpAddons\Sidebar\Widget\WidgetAbstract;
use SilverWpAddons\Translate;

/**
 * Recent Posts Wiget
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: RecentProjects.php 2184 2015-01-21 12:20:08Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage Sidebar\Widget
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */

class RecentProjects extends WidgetAbstract
{
    public function __construct()
    {
        // Configure widget array
        $args = array(
            // Widget Backend label
            'label'         => Translate::translate('Recent Projects'),
            'name'          => 'recent-projects',
            // Widget Backend Description
            //'description'   => Translate::translate('Blogposts with images from selected categories.'),
        );
        // Configure the widget fields
        // Example for: Title ( text ) and Amount of posts to show ( select box )
        // fields array
        $args['fields'] = array(
            // Title field
            array(
                'name'      => Translate::translate('Title'),
                'id'        => 'title',
                'type'      => 'text',
                'class'     => 'widefat',
                'validate'  => 'alpha_numeric',
                'filter'    => 'strip_tags|esc_attr',
                'std'       => Translate::translate('Recent Portfolio Project'),
            ),
            array(
                'name'      => Translate::translate('Number of posts to show'),
                'id'        => 'limit',
                'type'      => 'number',
                'class'     => 'widefat',
                'std'       => 5,
                'validate'  => 'numeric',
            ),

            array(
                'name'      => Translate::translate('Categories'),
                'id'        => 'cats',
                'type'      => 'category_portfolio_cb',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info' ),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Layout'),
                'id'        => 'layout',
                'type'      => 'select',
                'class'     => 'widefat',
                'value'     => 'list',
                //'validate'  => 'boolean',
                'fields'    => array(
                    array(
                        'name'  => Translate::translate('List with names of Projects'),
                        'value' => 'list',
                    ),
                    array(
                        'name'  => Translate::translate('Grid with images only'),
                        'value' => 'grid',
                    )
                    
                )
            ),
            // add more fields
        ); // fields array
        try {
            $this->createWidget($args);
        } catch (Exception $ex) {
            echo $ex->displayAdminNotice();
        }
        // create widget
        
    }
    
    public function widget($args, $instance)
    {
        $Portfolio = Portfolio::getInstance()->setThumbnailSize('post-thumbnail');
        
        $instance['title'] = empty($instance['title'])
                ? Translate::translate('Recent portfolio projects') : $instance['title'];
        
        \apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
                
        $query_args = array();
        if (isset($instance['cats']) && $instance['cats'] != '' && \count($instance['cats'])) {
            $query_args = $Portfolio->getTaxonomy()->getCategoryQueryArgs($instance['cats']);
        }
        $items = $Portfolio->getQueryData($instance['limit'], false, $query_args);
        
        $data = array(
            'args'      => $args,
            'data'      => $items,
            'instance'  => $instance,
        );
        $this->render($data);
    }
}
