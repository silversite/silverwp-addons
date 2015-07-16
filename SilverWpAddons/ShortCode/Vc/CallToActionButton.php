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
 Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/CallToActionButton.php $
 Last committed: $Revision: 2224 $
 Last changed by: $Author: padalec $
 Last changed date: $Date: 2015-01-23 14:59:37 +0100 (Pt, 23 sty 2015) $
 ID: $Id: CallToActionButton.php 2224 2015-01-23 13:59:37Z padalec $
*/
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vc\Control\Animation;
use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\Color;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Link;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\WpEditor;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\CallToActionButton' ) ) {

    /**
     * Short Code Recent Blog Posts small
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at dynamite-studio.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class CallToActionButton extends ShortCodeAbstract {
        protected $tag_base = 'ds_cta_button';
        //protected $js_view = 'DsCallToActionView';

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
         * Add view js helper
         *
         * @return string
         * @access protected
         */
        protected function getEnqueueAdminJs() {
            $js = ASSETS_URI . 'js/vc/admin/cta_button.js';

            return $js;
        }

        /**
         * Create short code
         *
         * @return void
         * @access protected
         */
        protected function create() {
            $this->setLabel( Translate::translate( 'Call to action button' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
            $this->setIcon( 'icon-wpb-call-to-action' );

            $content = new WpEditor( 'content' );
            $content->setLabel( Translate::translate( 'Promotional text' ) );
            $this->addControl( $content );

            $title = new Text( 'title' );
            $title->setLabel( Translate::translate( 'Text' ) );
            $title->setValue( Translate::translate( 'Text on the button' ) );
            $title->setDescription( Translate::translate( 'Text on the button' ) );
            $title->setAdminLabel( true );
            $this->addControl( $title );

            $url = new Link( 'link', 'link' );
            $url->setLabel( Translate::translate( 'URL (Link)' ) );
            $this->addControl( $url );

            $style = new Select( 'style' );
            $style->setLabel( Translate::translate( 'Button style' ) );
            $styles = silverwp_get_button_style();
            $style->setOptions( $styles );
            $style->setDescription( Translate::translate( 'Text align in call to action block.' ) );
            $this->addControl( $style );

            $color = new Color( 'color' );
            $color->setLabel( Translate::translate( 'Color' ) );
            $color->setDescription( Translate::translate( 'Button color.' ) );
            $this->addControl( $color );

            $size = new Select( 'size' );
            $size->setLabel( Translate::translate( 'Size' ) );
            $size_list = silverwp_get_sc_button_size();
            $size->setOptions( $size_list );
            $size->setDescription( Translate::translate( 'Button size.' ) );
            $this->addControl( $size );

            $position = new Select( 'position' );
            $position->setLabel( Translate::translate( 'Button position' ) );
            $position_list = silverwp_get_button_position();
            $position->setOptions( $position_list );
            $position->setDescription( Translate::translate( 'Select button alignment.' ) );
            $this->addControl( $position );

            $border = new Checkbox( 'border' );
            $border->setLabel( Translate::translate( 'Border ?' ) );
            $border->setValue( array( Translate::translate( 'Yes please' ) => '1' ) );
            $border->setDescription( Translate::translate( 'Button border. If enabled You have to define border color.' ) );
            $border->setGroup( Translate::translate( 'Border' ) );
            $this->addControl( $border );

            $border_color = new Color( 'border_color' );
            $border_color->setLabel( Translate::translate( 'Border color' ) );
            $border_color->setDependency( 'border', array( '1' ) );
            $border_color->setDescription( Translate::translate( 'Choice border color from colors list.' ) );
            $border_color->setGroup( Translate::translate( 'Border' ) );
            $border_color->setDependency( 'border', array( '1' ) );
            $this->addControl( $border_color );

            $rounded = new Checkbox( 'rounded' );
            $rounded->setLabel( Translate::translate( 'Rounded ?' ) );
            $rounded->setValue( array( Translate::translate( 'Yes please' ) => '1' ) );
            $rounded->setDescription( Translate::translate( 'Button border style rounded' ) );
            $rounded->setGroup( Translate::translate( 'Border' ) );
            $rounded->setDependency( 'border', array( '1' ) );
            $this->addControl( $rounded );

            $animation = new Animation();
            $this->addControl( $animation );

            $el_css = new ExtraCss();
            $this->addControl( $el_css );
        }
    }
}
