<?php
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\Debug;
use SilverWp\ShortCode\Vc\Control\Animation;
use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Slider;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\Portfolio' ) ) {

    /**
     * Short Code portfolio
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision$
     */
    class Portfolio extends ShortCodeAbstract {
        protected $tag_base = 'ds_projects';

        public function content( $args, $content ) {

            $portfolio = \SilverWpAddons\PostType\Portfolio::getInstance();

            $categories = array();
            if ( $portfolio->isTaxonomyRegistered() ) {
                $categories = $portfolio->getTaxonomy()
                                        ->getAllTerms( 'category', array( 'hide_empty' => true ) ); // filter

            }
            Debug::dump($categories);
            $content = $portfolio->getQueryData( $args[ 'limit' ] );

            $default = $this->prepareAttributes();

            $attributes                 = $this->setDefaultAttributeValue( $default, $args );
            $attributes[ 'categories' ] = $categories;

            $view = $this->render( $attributes, $content );

            return $view;
        }

        /**
         * Create short code settings
         *
         * @access public
         * @return void
         */

        protected function create() {
            $this->setLabel( Translate::translate( 'Portfolio' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );

            $assets_uri = $this->getAssetsUri();
            $this->addFrontJs( $assets_uri . 'js/plugins/magnificpopup/jquery.mp.min.js' );
            $this->addFrontCss( $assets_uri . 'css/magnific-popup.css' );

            $post_limit = new Slider( 'limit' );
            $post_limit->setLabel( Translate::translate( 'Project Count' ) );
            $post_limit->setMin( 3 );
            $post_limit->setMax( 30 );
            $post_limit->setStep( 1 );
            $post_limit->setDefault( 12 );
            $this->addControl( $post_limit );
            //add filters
            $filters = new Checkbox( 'filters' );
            $filters->setLabel( Translate::translate( 'Enable filters?' ) );
            $filters->setValue( array( Translate::translate( 'Yes' ) => 1 ) );
            $this->addControl( $filters );

            $animation = new Animation();
            $this->addControl( $animation );

            $el_css = new ExtraCss();
            $this->addControl( $el_css );
        }

        /**
         *
         * Add front JS script
         *
         * @return string
         * @access public
         * @todo check this
         */
        public function addFrontJs() {
            $assets_uri = $this->getAssetsUri();

            $params[ 'magnific_popup_js' ] = array(
                'url'       => $assets_uri . 'js/plugins/magnificpopup/jquery.mp.min.js',
                'deps'      => array( 'jquery' ),
                'in_footer' => true,
                'ver'       => '1.0.0',
            );

            return $params;
        }

        /**
         * Add CSS script
         *
         * @return string
         * @access public
         * @todo check this
         */
        public function addFrontCss() {
            $assets_uri = $this->getAssetsUri();

            $params[ 'magnific_popup' ] = array(
                'url' => $assets_uri . 'css/magnific-popup.css',
            );

            return $params;
        }
    }
} 