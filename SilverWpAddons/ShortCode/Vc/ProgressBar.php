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

use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\Color;
use SilverWp\ShortCode\Vc\Control\ExplodedTextArea;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\Translate;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\ProgressBar' ) ) {

    /**
     * Short Code Progress Bar
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright SilverSite.pl 2014
     * @version $Id: ProgressBar.php 2260 2015-01-28 15:53:30Z padalec $
     */
    class ProgressBar extends ShortCodeAbstract {
        protected $tag_base = 'ss_progress_bar';

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
            $args[ 'front_image' ]   = isset( $args[ 'front_image' ] ) ? $this->imageId2Url( $args[ 'front_image' ] ) : '';
            $args[ 'reverse_image' ] = isset( $args[ 'reverse_image' ] ) ? $this->imageId2Url( $args[ 'reverse_image' ] ) : '';

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
            $this->setLabel( Translate::translate( 'Progress Bar' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
            $this->setIcon( 'icon-wpb-graph' );

            $values = new ExplodedTextArea( 'values' );
            $values->setLabel( Translate::translate( 'Graphic values' ) );
            $values->setDescription( Translate::translate( 'Input graph values, titles and color here. Divide values with linebreaks (Enter). Example: 90|Development|#e75956' ) );
            $values->setValue( '90|Development,80|Design,70|Marketing' );
            $this->addControl( $values );

            $units = new Text( 'units' );
            $units->setLabel( Translate::translate( 'Units' ) );
            $units->setDescription( Translate::translate( 'Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.' ) );
            $this->addControl( $units );

            $bg_color = new Color( 'bg_color' );
            $bg_color->setLabel( Translate::translate( 'Bar color' ) );
            $bg_color->setDescription( Translate::translate( 'Select bar background color.' ) );
            $bg_color->setAdminLabel( true );
            $this->addControl( $bg_color );

            $options = new Checkbox( 'options' );
            $options->setLabel( Translate::translate( 'Options' ) );
            $options->setOptions(
                array(
                    Translate::translate( 'Add Stripes?' )                                      => 'striped',
                    Translate::translate( 'Add animation? Will be visible with striped bars.' ) => 'animated'
                ),
                false
            );
            $this->addControl( $options );

            $label_position = new Select( 'label_position' );
            $label_position->setLabel( Translate::translate( 'Label position' ) );
            $label_position->setValue(
                array(
                    Translate::translate( 'Inside the progress bar' ) => 'inside_bar',
                    Translate::translate( 'Above the progress bar' )  => 'above_bar',
                )
            );
            $this->addControl( $label_position );

            $rounded_style = new Select( 'rounded_style' );
            $rounded_style->setLabel( Translate::translate( 'Rounded style' ) );
            $rounded_styles = silverwp_get_rounded_style();
            $rounded_style->setOptions( $rounded_styles );
            //$rounded_style->setDescription( Translate::translate( 'Border style rounded' ) );
            $this->addControl( $rounded_style );

            $el_css = new ExtraCss();
            $this->addControl( $el_css );

        }
    }
}