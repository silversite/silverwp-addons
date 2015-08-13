<?php
namespace SilverWpAddons\ShortCode;

use SilverWpAddons\ShortCode\Vc\MessageBox;
use SilverWpAddons\ShortCode\Vc\Quote;
use SilverWp\ShortCode\Vc\SetupAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Setup' ) ) {
    /**
     *
     * Main Short Code class add, remove, change settings
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage SilverWpAddons
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class Setup extends SetupAbstract {

        public static $un_register = array( 'gravityform' );

        /**
         * Register short codes
         *
         * @access protected
         */
        protected function register() {
            new Quote();
	        //new PostsList();
	    }
    }
}