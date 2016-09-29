<?php
namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Helper\Control\Attachments;
use SilverWp\Helper\Control\Gallery;
use SilverWp\Helper\Control\Upload;
use SilverWp\Helper\Control\Wpeditor;
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

			$section_two = new Textarea( 'section_kostka' );
			$section_two->setLabel( Translate::translate( 'O firmie kostka' ) );
			$this->addControl( $section_two );

			$section_three = new Textarea( 'section_kontakt1' );
			$section_three->setLabel( Translate::translate( 'O firmie kontakt 1' ) );
			$this->addControl( $section_three );

			$section_kontakt2 = new Textarea( 'section_kontakt2' );
			$section_kontakt2->setLabel( Translate::translate( 'O firmie kontakt 2' ) );
			$this->addControl( $section_kontakt2 );
		}
	}
}