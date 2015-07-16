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
use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\Color;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Image;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\TextArea;
use SilverWp\SilverWp;
use SilverWp\Translate;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Counter' ) ) {

    /**
     * Short Code Counter
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class Counter extends ShortCodeAbstract {
        protected $tag_base = 'ss_counter';

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
            $args[ 'bg_image' ] = isset( $args[ 'bg_image' ] ) ? $this->imageId2Url( $args[ 'bg_image' ] ) : '';

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
            $this->setLabel( Translate::translate( 'Counter' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );

            $css_uri = FileSystem::getDirectory( 'css_uri' );
            $this->setAdminEnqueueCss( $css_uri . 'colors.css');

            $label_before = new Text( 'label_before' );
            $label_before->setLabel( Translate::translate( 'Label before value' ) );
            $label_before->setDescription( Translate::translate( 'Label before counter value.' ) );
            $label_before->setAdminLabel( true );
            $this->addControl( $label_before );

            $value = new Text( 'value' );
            $value->setLabel( Translate::translate( 'Counter value' ) );
            $value->setDescription( Translate::translate( 'Counter value.' ) );
            $value->setAdminLabel( true );
            $this->addControl( $label_before );

            $label_after = new Text( 'label_after' );
            $label_after->setLabel( Translate::translate( 'Label after value' ) );
            $label_after->setDescription( Translate::translate( 'Label after counter value.' ) );
            $label_after->setAdminLabel( true );
            $this->addControl( $label_after );

            $label_font_size = new Select( 'label_font_size' );
            $label_font_size->setLabel( Translate::translate( 'Label font size' ) );
            $font_size_list = silverwp_font_size_full();
            $label_font_size->setDefault( '72' );
            $label_font_size->setOptions( $font_size_list );
            $this->addControl( $label_font_size );

            $label_font_weight = new Select( 'label_font_weight' );
            $label_font_weight->setLabel( Translate::translate( 'Label font weight' ) );
            $font_weight_list = silverwp_font_weight_full();
            $label_font_weight->setOptions( $font_weight_list );
            $label_font_weight->setDefault( '400' );
            $label_font_weight->setDescription( Translate::translate( 'Not for every fonts all weights is available.' ) );
            $this->addControl( $label_font_weight );

            $text = new TextArea( 'text' );
            $text->setLabel( Translate::translate( 'Text' ) );
            $text->setDescription( Translate::translate( 'Text below label.' ) );
            $this->addControl( $text );

            $color = new Color( 'color' );
            $color->setLabel( Translate::translate( 'Label color' ) );
            $color->setDescription( Translate::translate( 'Text label color.' ) );
            $this->addControl( $color );

            $border = new Checkbox( 'border' );
            $border->setLabel( Translate::translate( 'Border ?' ) );
            $border->setValue( array( Translate::translate( 'Yes please' ) => '1' ) );
            $border->setDescription( Translate::translate( 'Counter border. If enabled You have to define border color.' ) );
            $this->addControl( $border );

            $border_color = new Color( 'border_color' );
            $border_color->setLabel( Translate::translate( 'Border color' ) );
            $border_color->setDependency( 'border', array( '1' ) );
            $border_color->setDescription( Translate::translate( 'Choice border color from colors list.' ) );
            $this->addControl( $border_color );

            $rounded = new Checkbox( 'rounded' );
            $rounded->setLabel( Translate::translate( 'Rounded ?' ) );
            $rounded->setValue( array( Translate::translate( 'Yes please' ) => '1' ) );
            $rounded->setDescription( Translate::translate( 'Counter box rounded' ) );
            $this->addControl( $rounded );

            $bg_color = new Color( 'bg_color' );
            $bg_color->setLabel( Translate::translate( 'Background color' ) );
            $bg_color->setDescription( Translate::translate( 'Choice background color from colors list.' ) );
            $this->addControl( $bg_color );

            $bg_image = new Image( 'bg_image' );
            $bg_image->setLabel( Translate::translate( 'Background image' ) );
            $bg_image->setDescription( Translate::translate( 'Background image from media library or from Your hard drive.' ) );
            $this->addControl( $bg_image );

            $animation = new Animation();
            $this->addControl( $animation );

            $el_css = new ExtraCss();
            $this->addControl( $el_css );
        }
    }
}
