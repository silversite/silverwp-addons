<?php
/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
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
use SilverWp\ShortCode\Vc\Control\WpEditor;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Quote' ) ) {
	/**
	 * Short Code Quote
	 *
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    ShortCode
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @copyright (c) SilverSite.pl 2015
	 * @version       $Revision:$
	 */
	class Quote extends ShortCodeAbstract {
		protected $tag_base = 'ss_quote';

		/**
		 * Render Short Code content
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
			$this->setLabel( Translate::translate( 'Quote' ) );
			$this->setCategory( Translate::translate( 'Add by Silversite.pl' ) );
            $this->setDescription( Translate::translate( 'Citation with special styles' ) );
			$this->setIcon( 'icon-wpb-atm' );

			$editor = new WpEditor( 'content' );
			//important! this lines display information from field value in backend editor
			//in short code container
			$editor->setCssClass( 'messagebox_text' );
			$editor->setHolder( 'div' );

			$editor->setLabel( Translate::translate( 'Quotation text' ) );
			$editor->setValue( Translate::translate( '<p>I am message box. Click edit button to change this text.</p>' ) );
			$this->addControl( $editor );

			$author = new Text( 'author' );
			$author->setLabel( Translate::translate( 'Author' ) );
			$this->addControl( $author );

			$animation = new Animation();
			$this->addControl( $animation );

			$extra_css = new ExtraCss();
			$this->addControl( $extra_css );
		}
	}
}
