<?php
namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Helper\Control\Attachments;
use SilverWp\Helper\Control\Gallery;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Page' ) ) {
	/**
	 * Meta box for Pages
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id: Page.php 2563 2015-03-12 14:23:49Z padalec $
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Page extends MetaBoxAbstract {
		protected $id = 'page';
		protected $post_types = array( 'page' );
		protected $exclude_columns = array( 'category', 'tag' );

		protected function setUp() {
			$about = new Textarea( 'about' );
			$about->setLabel( Translate::translate( 'About' ) );
			$this->addControl( $about );

			$title = new Text( 'title' );
			$title->setLabel( Translate::translate( 'Title' ) );
			$this->addControl( $title );

			$attachments = new Attachments( 'attachments' );
			$attachments->setLabel( Translate::translate( 'Attachments' ) );
			$this->addControl( $attachments );

		}
	}
}