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
 Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Row.php $
 Last committed: $Revision: 2193 $
 Last changed by: $Author: padalec $
 Last changed date: $Date: 2015-01-21 16:33:54 +0100 (Śr, 21 sty 2015) $
 ID: $Id: Row.php 2193 2015-01-21 15:33:54Z padalec $
*/
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\ShortCodeUpdateAbstract;
use SilverWp\Translate;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\Row' ) ) {

    /**
     * Change short code row
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Id: Row.php 2193 2015-01-21 15:33:54Z padalec $
     */
    class Row extends ShortCodeUpdateAbstract {
        protected $tag_base = 'vc_row';

        protected $remove_form_element = array(
            'el_class',
        );

        /**
         * Add custom fields attribute form
         *
         * @access protected
         */
        protected function create() {
            $full_width = new Checkbox( 'full_width' );
            $full_width->setLabel( Translate::translate( 'Full-width content' ) );
            $full_width->setValue( array( Translate::translate( 'Yes' ) => '1' ) );
            $full_width->setWeight( 1 );
            $full_width->setGroup( Translate::translate( 'General' ) );
            $this->addControl( $full_width );

            $el_class = new ExtraCss();
            $this->addControl( $el_class );

        }

        /**
         * Render Short Code content
         *
         * @param array  $args short code attributes
         * @param string $content content string added between short code tags
         *
         * @return mixed
         * @access public
         */
        public function content( $args, $content ) {
            // TODO: Implement content() method.
        }
    }
}