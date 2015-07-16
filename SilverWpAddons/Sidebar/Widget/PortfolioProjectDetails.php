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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/Sidebar/Widget/PortfolioProjectDetails.php $
  Last committed: $Revision: 2184 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-21 13:20:08 +0100 (Śr, 21 sty 2015) $
  ID: $Id: PortfolioProjectDetails.php 2184 2015-01-21 12:20:08Z padalec $
 */

namespace SilverWpAddons\Sidebar\Widget;

use SilverWpAddons\Helper\Option;
use SilverWpAddons\PostType\Portfolio;
use SilverWpAddons\Translate;

/**
 * Portfolio Project Details Widget
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: PortfolioProjectDetails.php 2184 2015-01-21 12:20:08Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage Sidebar\Widget
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */

class PortfolioProjectDetails extends WidgetAbstract
{
    public function __construct()
    {
        // Configure widget array
        $args = array(
            // Widget Backend label
            'label'         => Translate::translate('Portfolio Project Details'),
            'name'          => 'portfolio_project_details',
            // Widget Backend Description
            'description'   => Translate::translate('Enabled only on single Project view with sidebar.'),
        );
        $this->createWidget($args);
    }

    // Output function

    public function widget($args, $instance)
    {
        $Portfolio = Portfolio::getInstance();
        //widget <section>
        $out = $args['before_widget'];
        //SilverWpAddons_debug_array(get_post_type());
        if (is_single() && get_post_type() === $Portfolio->getName()) {
            // widget title
            $out .= $args['before_title'];
            $out .= isset( $instance['title'] ) && $instance['title']
                    ? $instance['title']
                    : Translate::translate('Project Details');
            $out .= $args['after_title'] . "\n";

            // format output data
            $post_id = get_the_ID();

            $categories_string = '';
            $categories = $Portfolio->getTaxonomy()->getPostTerms($post_id);
            if ($categories) {
                foreach ($categories as $k => $category) {
                    if ($k !== 0) {
                        $categories_string .= ', ';
                    }
                    $categories_string .= $category['name'];
                }
            }

            $tags_string = '';
            $tags = $Portfolio->getTaxonomy()->getPostTerms($post_id, 'tag');
            foreach ($tags as $k => $tag) {
                if ($k !== 0) {
                    $tags_string .= ', ';
                }
                $tags_string .= $tag['name'];
            }

            $client = $Portfolio->getMetaBox()->getSingle('client', $post_id);

            $website = $Portfolio->getMetaBox()->getSingle('website', $post_id);

            $out .= '<ul>' . "\n";
            if (Option::get_theme_option('portfolio_item_date') === '1') {
                $timeClassCss = Option::get_theme_option('friendly_date_format') === '1' ? 'cutetime published' : 'published';
                $out .= '<li><strong>'. Translate::translate('Date') .'</strong> &nbsp; <time class="'. $timeClassCss .'" datetime="'. get_the_time('c') .'">'. get_the_date() .'</time></li>';
            }
            $out .= Option::get_theme_option('portfolio_item_date') === '1' ? '<li><strong>'. Translate::translate('Date') .'</strong> &nbsp; <time class="cutetime published" datetime="'. get_the_time('c') .'">'. get_the_date() .'</time></li>' : '';
            $out .= Option::get_theme_option('portfolio_item_author') === '1' ? '<li><strong>'. Translate::translate('Author') .'</strong> &nbsp; '. get_the_author() .'</li>' : '';
            $out .= $categories ? '<li><strong>'. Translate::translate('Category') .'</strong> &nbsp; '. $categories_string .'</li>' : '';
            $out .= $tags ? '<li><strong>'. Translate::translate('Tags') .'</strong> &nbsp; '. $tags_string .'</li>' : '';
            $out .= $client ? '<li><strong>'. Translate::translate('Client') .'</strong> &nbsp; '. $client .'</li>' : '';
            $out .= $website ? '<li><strong>'. Translate::translate('Website') .'</strong> &nbsp; <a href="'. $website .'" rel="nofollow" target="_blank">'. $website .'</a></li>' : '';
            $out .= '</ul>' . "\n";
        }
        //widget end </section>
        $out .= $args['after_widget'];

        echo $out;
    }
}
