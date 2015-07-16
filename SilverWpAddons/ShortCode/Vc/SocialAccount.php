<?php
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\Helper\Social;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( 'SilverWpAddons\ShortCode\Vc\SocialAccount' ) ) {
    /**
     * Social accounts
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) 2015 SilverSite.pl
     * @version $Revision:$
     */
    class SocialAccount extends ShortCodeAbstract {
        protected $tag_base = 'ds_social_accounts';

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

            $default                       = $this->prepareAttributes();
            $attributes                    = $this->setDefaultAttributeValue( $default, $args );
            $attributes[ 'accounts_list' ] = Social::getAccounts();
            $view                          = $this->render( $attributes, $content );

            return $view;
        }

        /**
         * This method is used to build setting form element
         *
         * @access protected
         */
        protected function create() {
            $this->setLabel( Translate::translate( 'Social accounts' ) );
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
            $this->setDescription( Translate::translate( 'Social account URLs are configured in Theme Options.' ) );
            $this->setIcon( 'icon-wpb-social' );

            $title = new Text( 'title' );
            $title->setLabel( Translate::translate( 'Title' ) );
            $title->setDescription(
                Translate::translate(
                    'Social accounts URLs are configured in <a href="themes.php?page=silverwp-theme_options#_social" target="_blank">Theme Options</a>'
                )
            );
            $title->setAdminLabel( true );
            $this->addControl( $title );
        }
    }
}