<?php
namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Text;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Posts' ) ) {
	/**
	 * Meta box for Posts
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id: Posts.php 2563 2015-03-12 14:23:49Z padalec $
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Posts extends MetaBoxAbstract {
		protected $id = 'post';
		protected $post_types = array( 'post' );
		protected $exclude_columns = array( 'category', 'tag' );

		protected function setUp() {
			$client_name = new Text( 'client_name' );
			$client_name->setLabel( Translate::translate( 'Nazwa klienta' ) );
			$this->addControl( $client_name );

			$facebook_url = new Text( 'facebook_url' );
			$facebook_url->setLabel( Translate::translate( 'Facebook URL' ) );
			$this->addControl( $facebook_url );

			$portfolio_url = new Text( 'portfolio_url' );
			$portfolio_url->setLabel( Translate::translate( 'Portfolio URL' ) );
			$this->addControl( $portfolio_url );
		}
	}
}