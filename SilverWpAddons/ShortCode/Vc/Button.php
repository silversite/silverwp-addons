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
 Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/ShortCode/Button.php $
 Last committed: $Revision: 2241 $
 Last changed by: $Author: padalec $
 Last changed date: $Date: 2015-01-27 10:35:29 +0100 (Wt, 27 sty 2015) $
 ID: $Id: Button.php 2241 2015-01-27 09:35:29Z padalec $
*/
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vc\Control\Animation;
use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\Color;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Fontello;
use SilverWp\ShortCode\Vc\Control\Link;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Button' ) ) {
    /**
     * Short Code Button
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at dynamite-studio.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class Button extends ShortCodeAbstract {
        protected $tag_base = 'ds_button';
        //protected $debug = 'ds_button';
        //protected $back_bone_js_view = 'VcButtonView';

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
            //TODO move this to filter method and add filters
            $args[ 'link' ] = isset( $args[ 'link' ] ) ? $this->buildLink( $args[ 'link' ] ) : '';

            $default = $this->prepareAttributes();

            $short_code_attributes = $this->setDefaultAttributeValue( $default, $args );
            $output                = $this->render( $short_code_attributes, $content );

            return $output;
        }

        /**
         * Create short code settings
         *
         * @access public
         * @return void
         */
        protected function create() {
            $this->setLabel(Translate::translate( 'Button' ));
            $this->setCategory(Translate::translate( 'Add by SilverSite.pl' ));
            $this->setIcon('icon-wpb-ui-button');

            $title = new Text( 'title' );
            $title->setLabel( Translate::translate( 'Text on the button' ) );
            $title->setValue( Translate::translate( 'Text on the button' ) );
            $title->setDescription( Translate::translate( 'Text on the button' ) );
            $title->setAdminLabel( true );
            $this->addControl( $title );

            $link = new Link( 'link' );
            $link->setLabel( Translate::translate( 'URL (Link)' ) );
            $this->addControl( $link );

            $style = new Select( 'style' );
            $style->setLabel( Translate::translate( 'Button style' ) );
            $style->setOptions( silverwp_get_button_style() );
            $this->addControl( $style );

            $custom_color = new Checkbox( 'custom_color' );
            $custom_color->setLabel( Translate::translate( 'Custom color' ) );
            $custom_color->setValue( array( Translate::translate( 'Use custom color' ) => '1' ) );
            $custom_color->setDescription( Translate::translate( 'If you set up color hear you can not configure color for this element in theme options.' ) );
            $this->addControl( $custom_color );

            $color = new Color( 'color' );
            $color->setLabel( Translate::translate( 'Color' ) );
            $color->setDependency( $custom_color, array( '1' ) );
            $this->addControl( $color );


            $transparent = new Checkbox( 'transparent' );
            $transparent->setLabel( Translate::translate( 'Transparent ?' ) );
            $transparent->setValue( array( Translate::translate( 'Only colorful border' ) => '1' ) );
            $this->addControl( $transparent );

            $size = new Select( 'size' );
            $size->setLabel( Translate::translate( 'Size' ) );
            $size->setOptions( silverwp_get_sc_button_size() );
            $this->addControl( $size );
            //$size->setStd('md');

            $add_icon = new Checkbox( 'add_icon' );
            $add_icon->setLabel( Translate::translate( 'Add icon ?' ) );
            $add_icon->setValue( array( Translate::translate( 'Yes please' ) => '1' ) );
            $this->addControl( $add_icon );

            $icon = new Fontello( 'icon' );
            $icon->setLabel( Translate::translate( 'Icon' ) );
            $icon->setDependency( $add_icon, array( '1' ) );
            $this->addControl( $icon );

            $icon_position = new Select( 'icon_position' );
            $icon_position->setLabel( Translate::translate( 'Icon position' ) );
            $icon_position->setOptions( silverwp_get_icon_position() );
            $icon_position->setDependency( $add_icon, array( '1' ) );
            $this->addControl( $icon_position );

            $animation = new Animation();
            $this->addControl( $animation );

            $el_css = new ExtraCss();
            $this->addControl( $el_css );
        }
    }
}
