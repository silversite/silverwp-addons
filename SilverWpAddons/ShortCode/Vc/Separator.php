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
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\FileSystem;
use SilverWp\ShortCode\Vc\Control\Color;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\SilverWp;
use SilverWp\Translate;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\Separator' ) ) {
    /**
     * Short Code Separator
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class Separator extends ShortCodeAbstract {
        protected $tag_base = 'ds_separator';

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
            $default               = $this->prepareAttributes();
            $short_code_attributes = $this->setDefaultAttributeValue( $default, $args );
            $output                = $this->render( $short_code_attributes, $content );

            return $output;
        }

        /**
         * This method is used to build setting form element
         *
         * @return mixed
         * @access protected
         */
        protected function create() {
            $css_uri = FileSystem::getDirectory( 'css_uri' );
            $js_uri  = FileSystem::getDirectory( 'js_uri' );

            $this->setIcon( 'icon-wpb-ui-separator' );
            $this->setLabel( Translate::translate( 'Separator' ) );
            $this->setDescription( Translate::translate( 'Horizontal separator line with heading.' ) );
            $this->setJsView( 'DsSeparatorView' );
            $this->setViewClassName( '\SilverWpAddons\ShortCode\View\MessageBox' );
            $this->setAdminEnqueueCss( $css_uri . 'vc/admin/separator.css' );
            $this->setAdminEnqueueJs( $js_uri . 'vc/admin/separator.js' );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );

            $color = new Color( 'color' );
            $color->setLabel( Translate::translate( 'Color' ) );
            $color->setDescription( Translate::translate( 'Separator color.' ) );
            $this->addControl( $color );

            $style = new Select( 'style' );
            $style->setLabel( Translate::translate( 'Separator style' ) );
            $style_list = silverwp_get_separator_style();
            $style->setOptions( $style_list );
            $style->setDescription( Translate::translate( 'Separator style.' ) );
            $this->addControl( $style );

            $el_width = new Select( 'el_width' );
            $el_width->setLabel( Translate::translate( 'Element width' ) );
            $el_width_list = silverwp_get_separator_width();
            $el_width->setOptions( $el_width_list );
            $el_width->setDescription( Translate::translate( 'Separator element width in percents.' ) );
            $this->addControl( $el_width );

            //field Extra class name (input text)
            $el_css = new ExtraCss();
            $this->addControl( $el_css );
        }
    }
}