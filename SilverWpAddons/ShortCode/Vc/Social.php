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
use SilverWp\ShortCode\Vc\Control\WpEditor;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Social' ) ) {
	/**
	 * Shortcode Social
	 *
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    ShortCode
	 * @author        Marcin Dobroszek <marcin at silversite.pl>
	 * @copyright (c) Silversite.pl 2015
	 * @version       $Revision:$
	 */
	class Social extends ShortCodeAbstract {
		protected $tag_base = 'ss_social';

		/**
		 * Render Shortcode content
		 *
		 * @param array  $args    shortcode attributes
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
		 * Create shortcode settings
		 *
		 * @access public
		 * @return void
		 */
		protected function create() {
			$this->setLabel( Translate::translate( 'Social' ) );
			$this->setCategory( Translate::translate( 'Add by Silversite.pl' ) );
            $this->setDescription( Translate::translate( 'One-row list with social account links' ) );
			$this->setIcon( 'icon-wpb-row' );

            // get data from Theme Options
            $social_accounts = \SilverWp\Helper\Social::getAccounts();

            foreach ( $social_accounts as $social_item ) {
                $social_field = new Text( $social_item[ 'slug' ] );
                $social_field->setLabel( $social_item[ 'name' ] );
                $social_field->setDefault( esc_url( $social_item[ 'url' ] ) );
                $social_field->setDescription( sprintf( Translate::translate( 'Add link to your personal %s account.' ), $social_item[ 'name' ] ) );
                $this->addControl( $social_field );
            }

			$animation = new Animation();
			$this->addControl( $animation );

			$extra_css = new ExtraCss();
			$this->addControl( $extra_css );
		}
	}
}
