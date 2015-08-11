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
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vp\Menu\Element\ElementAbstract;

if (!class_exists('SilverWpAddons\ShortCode\Vc\Img')) {
    /**
     *
     * Img short code (html <img src.. />)
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: Img.php 2184 2015-01-21 12:20:08Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class Img extends ElementAbstract {
        protected $name = 'img';

        /**
         * for short code not displayed in generator
         * only replace from interface
         */
        public function createElements() {
            return;
        }

        /**
         * Render content
         *
         * @param array  $args
         * @param string $content
         *
         * @return string
         * @access public
         */
        public function content( $args, $content = '' ) {
            $data    = array(
                'args' => $args,
            );
            $content = $this->render( $data );

            return $content;
        }
    }
}