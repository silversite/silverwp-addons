<?php
/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
 *
 * SilverWpAddons is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * SilverWpAddons is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace SilverWpAddons\ShortCode\Vc\View;

use SilverWp\ShortCode\Vc\View\ViewAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\View\MessageBox' ) ) {

    /**
     * Short Code message box
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at dynamite-studio.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class MessageBox extends ViewAbstract {

        /**
         * Remove title and icon for short code preview in editor
         *
         * @param string $title
         *
         * @return string
         * @access public
         */
        public function outputTitle( $title ) {
            return '';
        }
    }
}