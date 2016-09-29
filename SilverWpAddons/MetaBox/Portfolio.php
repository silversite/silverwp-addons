<?php
namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Checkbox;
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Upload;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Portfolio' ) ) {
	/**
	 * Meta box for Portfolios
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id: Portfolio.php 2563 2015-03-12 14:23:49Z padalec $
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Portfolio extends MetaBoxAbstract {
		protected $exclude_columns = array( 'category', 'tag' );

		protected function setUp() {
			$subtitle = new Text( 'subtitle' );
			$subtitle->setLabel( Translate::translate( 'Podtytuł' ) );
			$this->addControl( $subtitle );

			$client_name = new Text( 'client_name' );
			$client_name->setLabel( Translate::translate( 'Nazwa klienta' ) );
			$this->addControl( $client_name );

			$portfolio_url = new Text( 'portfolio_url' );
			$portfolio_url->setValidation( 'url' );
			$portfolio_url->setLabel( Translate::translate( 'Link do portfolio' ) );
			$this->addControl( $portfolio_url );

			$image = new Upload( 'home_image' );
			$image->setValidation( 'image' );
			$image->setLabel( Translate::translate( 'Zdjęcie na głównej' ) );
			$this->addControl( $image );

			$checkbox = new Checkbox( 'show_on_home' );
			$checkbox->setLabel( Translate::translate( 'Pokaż na głównej' ) );
			$this->addFilterControl( $checkbox );
		}
	}
}