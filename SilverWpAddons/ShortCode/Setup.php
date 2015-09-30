<?php
namespace SilverWpAddons\ShortCode;

use SilverWpAddons\ShortCode\Vc\Gallery;
use SilverWpAddons\ShortCode\Vc\GoogleMaps;
use SilverWpAddons\ShortCode\Vc\MessageBox;
use SilverWpAddons\ShortCode\Vc\PostsList;
use SilverWpAddons\ShortCode\Vc\Quote;
use SilverWpAddons\ShortCode\Vc\Banner;
use SilverWpAddons\ShortCode\Vc\Social;
use SilverWp\ShortCode\Vc\SetupAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Setup' ) ) {
	/**
	 *
	 * Main Short Code class add, remove, change settings
	 *
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    ShortCode
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @copyright     SilverSite.pl (c) 2015
	 * @version       0.6
	 */
	class Setup extends SetupAbstract {

		public static $un_register = array( 'gravityform' );

		/**
		 * Register short codes
		 *
		 * @access protected
		 */
		protected function register() {
			new Banner();
			new Quote();
			new PostsList();
			new GoogleMaps();
            new Social();
			// shortcodes not implemented to editor
			new Dropcap();
			new Highlight();
			// shortcodes to section "About the Author"
			new Links();
			new Link();
			new Gallery();
		}
	}
}