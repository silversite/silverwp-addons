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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/mango/wp-content/themes/silverwp/lib/SilverWpAddons/ShortCode/Generator/Menu/Element/Title.php $
  Last committed: $Revision: 1582 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2014-10-02 20:43:56 +0200 (Cz, 02 paź 2014) $
  ID: $Id: Title.php 1582 2014-10-02 18:43:56Z padalec $
 */

namespace SilverWpAddons\ShortCode\Generator\Menu\Element;

use SilverWpAddons\Translate;

/**
 *
 * Title short code and menu elements
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @author Marcin Dobroszek <marcin at silversite.pl>
 * @version $Id: Title.php 1582 2014-10-02 18:43:56Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage ShortCode\Generator\Menu\Element
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class TitleLarge extends ElementAbstract {
    protected $name = 'tlarge';
    protected $with_close_tag = false;

    public function createElements() {
        $attributes = array(
            //$this->hidden('size', Translate::translate('Title text')), // to do
            $this->text( 'text', Translate::translate( 'Title text' ) ),
            $this->textarea( 'description', Translate::translate( 'Below description' ) ),
        );
        $elements   = $this->addElement( Translate::translate( 'Large title (H2)' ), $attributes );

        return $elements;
    }

    /**
     * Title short code render function
     *
     * @param array $args short code attributes
     *
     * @return string
     * @access public
     */
    public function shortCode( $args, $content ) {
        $data    = array(
            'args'    => $args,
            'content' => $content,
        );
        $content = $this->render( $data );

        return $content;
    }
}
