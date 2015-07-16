<?php
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\WpEditor;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\Testimonial' ) ) {

    /**
     * Short Code Testimonial
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright SilverSite.pl 2015
     * @version $Revision:$
     */
    class Testimonial extends ShortCodeAbstract {
        protected $tag_base = 'ds_testimonial';
        //protected $back_bone_js_view = 'VcTestimonialView';

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
            $this->setLabel( Translate::translate( 'Testimonial' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );

            $content = new WpEditor( 'content' );
            $content->setLabel( Translate::translate( 'Quotation' ) );
            //$quotation->setDescription( Translate::translate( 'Quotation.' ) );
            $this->addControl( $content );

            $author_name = new Text( 'author_name' );
            $author_name->setLabel( Translate::translate( 'Author name' ) );
            //$author_name->setDescription( Translate::translate( 'Quotation.' ) );
            $this->addControl( $author_name );

            $author_description = new Text( 'author_description' );
            $author_description->setLabel( Translate::translate( 'Author description' ) );
            $author_description->setDescription( Translate::translate( 'Company name or workplace.' ) );
            $this->addControl( $author_description );
            //field Extra class name (input text)
            $el_css = new ExtraCss();
            $this->addControl( $el_css );
        }
    }
}