<?php
/*
 * Copyright (C) 2014 Marcin Dobroszek <marcin at silversite.pl>
 *
 * SilverWpAddons is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * SilverWpAddons is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vc\Control\Animation;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\Link;
use SilverWp\ShortCode\Vc\Control\Image;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\Banner' ) ) {
	/**
	 * Shortcode Banner
	 *
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    ShortCode
	 * @author        Marcin Dobroszek <marcin at silversite.pl>
	 * @copyright (c) SilverSite.pl 2015
	 * @version       $Revision:$
	 */
	class Banner extends ShortCodeAbstract {
		protected $tag_base = 'ss_banner';

		/**
		 * Render Shortcode content
		 *
		 * @param array  $args    short code attributes
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
		 * Create short code settings
		 *
		 * @access public
		 * @return void
		 */
		protected function create() {
			$this->setViewClassName( 'SilverWpAddons\ShortCode\Vc\View\Banner' );
			$this->setLabel( Translate::translate( 'Banner Image' ) );
			$this->setCategory( Translate::translate( 'Add by Silversite.pl' ) );
            $this->setDescription( Translate::translate( 'Image block with text and link to page' ) );
			$this->setIcon( 'vc_icon-vc-gitem-image' ); // icon-wpb-single-image

			$bnr_name = new Text( 'name' );
            $bnr_name->setLabel( Translate::translate( 'Text' ) );
            $bnr_name->setAdminLabel( true );
			$this->addControl( $bnr_name );

            $bnr_link = new Link( 'url' );
            $bnr_link->setLabel( Translate::translate( 'URL (Link)' ) );
            $bnr_link->setDescription( Translate::translate( 'Add link to banner.' ) );
            $this->addControl( $bnr_link );

            $bnr_img = new Image( 'image' );
            $bnr_img->setLabel( Translate::translate( 'Image' ) );
			$bnr_img->setDescription( Translate::translate( 'Add banner image.' ) );
            $this->addControl( $bnr_img );

            $bnr_img_size = new Text( 'size' );
            $bnr_img_size->setLabel( Translate::translate( 'Image size' ) );
            $bnr_img_size->setValue( Translate::translate( 'thumbnail' ) );
            $bnr_img_size->setDescription( Translate::translate('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.') );
            $this->addControl( $bnr_img_size );

			$animation = new Animation();
			$this->addControl( $animation );

			$extra_css = new ExtraCss();
			$this->addControl( $extra_css );
		}
	}
}
