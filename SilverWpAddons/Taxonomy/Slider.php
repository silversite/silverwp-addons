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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/Taxonomy/Slider.php $
  Last committed: $Revision: 2184 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-21 13:20:08 +0100 (Śr, 21 sty 2015) $
  ID: $Id: Slider.php 2184 2015-01-21 12:20:08Z padalec $
 */
namespace SilverWpAddons\Taxonomy;

use SilverWpAddons\Translate;

/**
 * taxonomy for Slider
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: Slider.php 2184 2015-01-21 12:20:08Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage Taxonomy
 */

class Slider extends TaxonomyAbstract
{
    protected $taxonomies = array(
        array(
            'name'   => 'category',
            'args'   => array(
                'public'            => true,
                'show_in_nav_menus' => true,
                'show_ui'           => true,
                'show_tagcloud'     => false,
                'hierarchical'      => true,
                'query_var'         => true
            ),
        ),
    );

    protected function setLabels()
    {
        $this->labels['category'] = array(
            'name'          => Translate::translate('Slider categories'),
            'singular_name' => Translate::translate('Slider category'),
            'menu_name'     => Translate::translate('Slider categories'),
        );
    }
}
