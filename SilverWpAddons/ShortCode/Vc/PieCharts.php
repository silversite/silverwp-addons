<?php
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\Color;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Fontello;
use SilverWp\ShortCode\Vc\Control\Slider;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\TextArea;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\PieCharts' ) ) {
    /**
     * Short Code pie charts
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Id: PieCharts.php 2308 2015-02-02 13:35:21Z padalec $
     */
    class PieCharts extends ShortCodeAbstract {
        protected $tag_base = 'ds_pie';

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
            $default = $this->prepareAttributes();

            wp_enqueue_script( 'vc_pie' );

            $short_code_attributes = $this->setDefaultAttributeValue( $default, $args );
            $output                = $this->render( $short_code_attributes, $content );

            return $output;
        }

        /**
         * This method is used to build setting form element
         *
         * @return void
         * @access protected
         */
        protected function create() {
            $this->setLabel( Translate::translate( 'Pie chart' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
            $this->setIcon( 'icon-wpb-vc_pie' );

            $value = new Slider( 'value' );
            $value->setLabel( Translate::translate( 'Pie value' ) );
            $value->setDefault( 50 );
            $value->setMin( 0 );
            $value->setMax( 100 );
            $value->setStep( 1 );
            $value->setDescription( Translate::translate( 'Input graph value here. Choose range between 0 and 100.' ) );
            $value->setAdminLabel( true );
            $this->addControl( $value );

            $label_value = new TextArea( 'label_value' );
            $label_value->setLabel( Translate::translate( 'Pie label value' ) );
            $label_value->setDescription( Translate::translate( 'Input integer value for label. If empty "Pie value" will be used.' ) );
            $this->addControl( $label_value );

            $units = new Text( 'units' );
            $units->setLabel( Translate::translate( 'Units' ) );
            $units->setDescription( Translate::translate( 'Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.' ) );
            $this->addControl( $units );

            $size = new Slider( 'size' );
            $size->setLabel( Translate::translate( 'Size' ) );
            $size->setDefault( 50 );
            $size->setMin( 50 );
            $size->setMax( 200 );
            $size->setStep( 10 );
            $this->addControl( $size );

            $color = new Color( 'color' );
            $color->setLabel( Translate::translate( 'Color' ) );
            $this->addControl( $color );
            //$color->setDescription( Translate::translate( 'Select bar background color.' ) );
            //$color->setAdminLabel( true );

            $add_icon = new Checkbox( 'add_icon' );
            $add_icon->setLabel( Translate::translate( 'Add icon ?' ) );
            $add_icon->setValue( array( Translate::translate( 'Yes please' ) => '1' ) );
            $this->addControl( $add_icon );

            $icon = new Fontello( 'icon' );
            $icon->setLabel( Translate::translate( 'Icon' ) );
            $icon->setDescription( Translate::translate( 'Select icon.' ) );
            $icon->setDependency( $add_icon, array( '1' ) );
            $this->addControl( $icon );

            $el_class = new ExtraCss();
            $this->addControl( $el_class );
        }
    }
}