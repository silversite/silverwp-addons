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

use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Fontello;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\TextArea;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\IconBox' ) ) {
    /**
     * Short Code icon box
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class IconBox extends ShortCodeAbstract {
        protected $tag_base = 'ds_icon_box';

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

            $view = $this->render( $short_code_attributes, $content );

            return $view;
        }

        /**
         * This method is used to build setting form element
         *
         * @return mixed
         * @access protected
         */
        protected function create() {
            $this->setLabel( Translate::translate( 'Icon box' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );

            $title = new Text( 'title' );
            $title->setLabel( Translate::translate( 'Title' ) );
            $this->addControl( $title );

            $text = new TextArea( 'text' );
            $text->setLabel( Translate::translate( 'Text' ) );
            $this->addControl( $text );

            $icon = new Fontello( 'icon' );
            $icon->setLabel( Translate::translate( 'Icon' ) );
            $this->addControl( $icon );
            //field Extra class name (input text)
            $extra_css = new ExtraCss();
            $this->addControl( $extra_css );
        }
    }
}
