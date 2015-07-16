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
use SilverWp\ShortCode\Vc\Control\Animation;
use SilverWp\ShortCode\Vc\Control\Color;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Fontello;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\Control\WpEditor;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\MessageBox' ) ) {
    /**
     * Short Code message box
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision: 2216 $
     */
    class MessageBox extends ShortCodeAbstract {
        protected $tag_base = 'ss_alert';

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

            $default    = $this->prepareAttributes();
            $attributes = $this->setDefaultAttributeValue( $default, $args );
            $output     = $this->render( $attributes, $content );

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

            $this->setLabel( Translate::translate( 'Message box' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
            $this->setIcon( 'icon-wpb-information-white' );

            $this->setWrapperClass( 'alert' );
            $this->setJsView( 'DsMessageView' );
            $this->setViewClassName( '\SilverWpAddons\ShortCode\View\MessageBox' );
            $this->setAdminEnqueueCss( $css_uri . 'vc/admin/message_box.css' );
            $this->setAdminEnqueueJs( $js_uri . 'vc/admin/message_box.js' );

            $color = new Select( 'color' );
            $color->setLabel( Translate::translate( 'Message box type' ) );
            $color->setDescription( Translate::translate( 'Select message type.' ) );
            $color->setOptions( silverwp_get_messages_color() );
            $color->setParamHolder( 'vc_message-type' );
            $this->addControl( $color );

            $bg_color = new Color( 'bg_color' );
            $bg_color->setLabel( Translate::translate( 'Custom color' ) );
            $bg_color->setDescription( Translate::translate( 'Custom message background color.' ) );
            $bg_color->setDependency( $color, array( 'custom' ) );
            $this->addControl( $bg_color );

            $icon = new Fontello( 'icon' );
            $icon->setLabel( Translate::translate( 'Icon' ) );
            $icon->setDescription( Translate::translate( 'Select icon.' ) );
            $icon->setDependency( $color, array( 'custom' ) );
            $this->addControl( $icon );

            $editor = new WpEditor( 'content' );
            $editor->setCssClass( 'messagebox_text' );
            $editor->setHolder( 'div' );
            $editor->setValue( Translate::translate( '<p>I am message box. Click edit button to change this text.</p>' ) );
            $this->addControl( $editor );

            $animation = new Animation();
            $this->addControl( $animation );

            $el_css = new ExtraCss();
            $this->addControl( $el_css );

        }
    }
}