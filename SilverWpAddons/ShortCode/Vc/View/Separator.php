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
/*
 Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/View/Separator.php $
 Last committed: $Revision: 2216 $
 Last changed by: $Author: padalec $
 Last changed date: $Date: 2015-01-23 10:35:17 +0100 (Pt, 23 sty 2015) $
 ID: $Id: Separator.php 2216 2015-01-23 09:35:17Z padalec $
*/
namespace SilverWpAddons\ShortCode\Vc\View;

use SilverWp\ShortCode\Vc\View\ViewAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\View\Separator' ) ) {

    /**
     * View Short Code separator
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class Separator extends ViewAbstract {
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