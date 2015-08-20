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

use SilverWp\Interfaces\EnqueueScripts;
use SilverWp\ShortCode\Vc\Control\Checkbox;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Image;
use SilverWp\ShortCode\Vc\Control\Select;
use SilverWp\ShortCode\Vc\Control\Slider;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\TextArea;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\GoogleMaps' ) ) {
	/**
	 * Short Code GoogleMaps
	 *
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    ShortCode
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @copyright (c) SilverSite.pl 2015
	 * @version       0.1
	 */
	class GoogleMaps extends ShortCodeAbstract implements EnqueueScripts {
		protected $tag_base = 'ss_googlemaps';

		public function __construct() {
			parent::__construct();
			add_action( 'save_post', array( $this, 'saveOccurrencesPostsIds' ) ); //is post has our map shortcode
		}

		/**
		 * Save all posts ids where google map short code occurrences
		 *
		 * @param int $post_id
		 * @access public
		 */
		public function saveOccurrencesPostsIds( $post_id ) {
			if ( wp_is_post_revision( $post_id )) {
				return;
			}
			$post_type = get_post_type( $post_id );
			$id_array = $this->findOccurrences( $this->tag_base, $post_type );
			if ( false === add_option( $this->tag_base, $id_array ) ) {
				update_option( $this->tag_base, $id_array );
			}
		}

		/**
		 * Find all post id where short code occurrence
		 *
		 * @param $short_code
		 * @param $post_type
		 *
		 * @return array
		 * @access private
		 */
		private function findOccurrences( $short_code, $post_type ) {
			$found_ids    = array();
			$args         = array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
			);
			$query_result = new \WP_Query( $args );
			foreach ( $query_result->posts as $post ) {
				if ( false !== strpos( $post->post_content, $short_code ) ) {
					$found_ids[] = $post->ID;
				}
			}

			return $found_ids;
		}

		/**
		 * Enqueue scripts js or css
		 *
		 * @return void
		 * @access public
		 */
		public function enqueueScripts() {
			wp_register_script(
				'googleapis',
				'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'
			);
			if ( is_front_page() ) {
				$page_id = get_option( 'page_on_front' );
			} else {
				$page_id = get_the_ID();
			}
			//enqueue this script only on page or post where short code was founded
			$option_id_array = get_option( $this->tag_base );

			if ( $option_id_array ) {
				if ( ! empty( $option_id_array ) ) {
					if ( in_array( $page_id, $option_id_array ) ) {
						wp_enqueue_script( 'googleapis' );
					}
				}
			}
		}

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

			$args   = $this->setDefaultAttributeValue( $default, $args );
			$output = $this->render( $args, $content );

			return $output;
		}

		/**
		 * Create short code settings
		 *
		 * @access public
		 * @return void
		 */
		protected function create() {
			$this->setLabel( Translate::translate( 'Google Map' ) );
			$this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
			$this->setCssClass( 'vc_google_map' );
			$this->setDescription( Translate::translate( 'Display Google Maps to indicate your location' ) );
			$this->setIcon( 'vc_google_map' );
			$this->setShowSettingsForm( true );
			$this->setControls( 'full' );

			$text = new Text( 'width' );
			$text->setLabel( Translate::translate( 'Width (in %)' ) );
			$text->setGroup( Translate::translate( 'General Settings' ) );
			$text->setValue( '100%' );
			$text->setAdminLabel( true );
			$this->addControl( $text );

			$text = new Text( 'height' );
			$text->setLabel( Translate::translate( 'Height (in px)' ) );
			$text->setGroup( Translate::translate( 'General Settings' ) );
			$text->setValue( '300px' );
			$text->setAdminLabel( true );
			$this->addControl( $text );

			$map_type = new Select( 'map_type' );
			$map_type->setLabel( Translate::translate( 'Map type' ) );
			$map_type->setAdminLabel( true );
			$map_type->setGroup( Translate::translate( 'General Settings' ) );
			$map_type->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Roadmap' ),
						'value' => 'ROADMAP'
					),
					array(
						'label' => Translate::translate( 'Satellite' ),
						'value' => 'SATELLITE'
					),
					array(
						'label' => Translate::translate( 'Hybrid' ),
						'value' => 'HYBRID'
					),
					array(
						'label' => Translate::translate( 'Terrain' ),
						'value' => 'TERRAIN'
					)
				)
			);
			$map_type->setDefault( 'ROADMAP' );
			$this->addControl( $map_type );

			$text = new Text( 'lat' );
			$text->setLabel( Translate::translate( 'Latitude' ) );
			$text->setGroup( Translate::translate( 'General Settings' ) );
			$text->setDescription(
				Translate::translate(
					'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">
					Here is a tool</a> where you can find Latitude & Longitude of your location'
				)
			);
			$text->setValue( '18.591212' );
			$text->setAdminLabel( true );
			$this->addControl( $text );

			$text = new Text( 'lng' );
			$text->setLabel( Translate::translate( 'Longitude' ) );
			$text->setGroup( Translate::translate( 'General Settings' ) );
			$text->setDescription(
				Translate::translate(
					'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">
					Here is a tool</a> where you can find Latitude & Longitude of your location'
				)
			);
			$text->setValue( '73.741261' );
			$text->setAdminLabel( true );
			$this->addControl( $text );

			$zoom = new Slider( 'zoom' );
			$zoom->setLabel( Translate::translate( 'Map Zoom' ) );
			$zoom->setMin( 1 );
			$zoom->setMax( 20 );
			$zoom->setStep( 1 );
			$zoom->setDefault( 18 );
			$zoom->setGroup( Translate::translate( 'General Settings' ) );
			$this->addControl( $zoom );

			$scroll_wheel = new Checkbox( 'scrollwheel' );
			$scroll_wheel->setLabel( '' );
			$scroll_wheel->setGroup( Translate::translate( 'General Settings' ) );
			$scroll_wheel->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Disable map zoom on mouse wheel scroll' ),
						'value' => 'disable'
					)
				)
			);
			$this->addControl( $scroll_wheel );

			$street_view_control = new Select( 'streetviewcontrol' );
			$street_view_control->setLabel( Translate::translate( 'Street view control' ) );
			$street_view_control->setGroup( Translate::translate( 'General Settings' ) );
			$street_view_control->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Disable' ),
						'value' => 'false'
					),
					array(
						'label' => Translate::translate( 'Enable' ),
						'value' => 'true'
					),
				)
			);
			$street_view_control->setDefault( 'false' );
			$this->addControl( $street_view_control );

			$map_type_control = new Select( 'maptypecontrol' );
			$map_type_control->setLabel( Translate::translate( 'Map type control' ) );
			$map_type_control->setGroup( Translate::translate( 'General Settings' ) );
			$map_type_control->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Disable' ),
						'value' => 'false'
					),
					array(
						'label' => Translate::translate( 'Enable' ),
						'value' => 'true'
					),
				)
			);
			$map_type_control->setDefault( 'false' );
			$this->addControl( $map_type_control );

			$pan_control = new Select( 'pancontrol' );
			$pan_control->setLabel( Translate::translate( 'Map pan control' ) );
			$pan_control->setGroup( Translate::translate( 'General Settings' ) );
			$pan_control->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Disable' ),
						'value' => 'false'
					),
					array(
						'label' => Translate::translate( 'Enable' ),
						'value' => 'true'
					),
				)
			);
			$pan_control->setDefault( 'false' );
			$this->addControl( $pan_control );

			$zoom_control = new Select( 'zoomcontrol' );
			$zoom_control->setLabel( Translate::translate( 'Zoom control' ) );
			$zoom_control->setGroup( Translate::translate( 'General Settings' ) );
			$zoom_control->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Disable' ),
						'value' => 'false'
					),
					array(
						'label' => Translate::translate( 'Enable' ),
						'value' => 'true'
					),
				)
			);
			$zoom_control->setDefault( 'false' );
			$this->addControl( $zoom_control );

			$zoom_control_size = new Select( 'zoomcontrolsize' );
			$zoom_control_size->setLabel( Translate::translate( 'Zoom control size' ) );
			$zoom_control_size->setGroup( Translate::translate( 'General Settings' ) );
			$zoom_control_size->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Small' ),
						'value' => 'SMALL'
					),
					array(
						'label' => Translate::translate( 'Large' ),
						'value' => 'LARGE'
					),
				)
			);
			$zoom_control_size->setDefault( 'SMALL' );
			$zoom_control_size->setDependency( $zoom_control, array( 'true' ) );
			$this->addControl( $zoom_control_size );

			$marker_icon = new Select( 'marker_icon' );
			$marker_icon->setLabel( Translate::translate( 'Marker/Point icon' ) );
			$marker_icon->setGroup( Translate::translate( 'General Settings' ) );
			$marker_icon->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Use Google Default' ),
						'value' => 'default'
					),
					array(
						'label' => Translate::translate( 'Use Plugin\'s Default' ),
						'value' => 'default_self'
					),
					array(
						'label' => Translate::translate( 'Upload Custom' ),
						'value' => 'custom'
					),
				)
			);
			$marker_icon->setDependency( $zoom_control, array( 'true' ) );
			$this->addControl( $marker_icon );

			$icon_img = new Image( 'icon_img' );
			$icon_img->setDescription( Translate::translate( 'Upload the custom image icon.' ) );
			$icon_img->setGroup( Translate::translate( 'General Settings' ) );
			$icon_img->setDependency( $marker_icon, array( 'custom' ) );
			$this->addControl( $icon_img );

			$content = new TextArea( 'content' );
			$content->setLabel( Translate::translate( 'Info Window Text' ) );
			$content->setGroup( Translate::translate( 'General Settings' ) );
			$this->addControl( $content );

			$top_margin = new Select( 'top_margin' );
			$top_margin->setLabel( Translate::translate( 'Top margin' ) );
			$top_margin->setGroup( Translate::translate( 'General Settings' ) );
			$top_margin->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Page (small)' ),
						'value' => 'page_margin_top'
					),
					array(
						'label' => Translate::translate( 'Section (large)' ),
						'value' => 'page_margin_top_section'
					),
					array(
						'label' => Translate::translate( 'None' ),
						'value' => 'none'
					),
				)
			);
			$this->addControl( $top_margin );

			$map_override = new Select( 'map_override' );
			$map_override->setLabel( Translate::translate( 'Map Width Override' ) );
			$map_override->setGroup( Translate::translate( 'General Settings' ) );
			$map_override->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Default Width' ),
						'value' => '0'
					),
					array(
						'label' => Translate::translate( 'Apply 1st parent element\'s width' ),
						'value' => '1'
					),
					array(
						'label' => Translate::translate( 'Apply 2nd parent element\'s width' ),
						'value' => '2'
					),
					array(
						'label' => Translate::translate( 'Apply 3rd parent element\'s width' ),
						'value' => '3'
					),
					array(
						'label' => Translate::translate( 'Apply 4th parent element\'s width' ),
						'value' => '4'
					),
					array(
						'label' => Translate::translate( 'Apply 5th parent element\'s width' ),
						'value' => '5'
					),
					array(
						'label' => Translate::translate( 'Apply 6th parent element\'s width' ),
						'value' => '6'
					),
					array(
						'label' => Translate::translate( 'Apply 7th parent element\'s width' ),
						'value' => '7'
					),
					array(
						'label' => Translate::translate( 'Apply 8th parent element\'s width' ),
						'value' => '8'
					),
					array(
						'label' => Translate::translate( 'Apply 9th parent element\'s width' ),
						'value' => '9'
					),
					array(
						'label' => Translate::translate( 'Full Width' ),
						'value' => 'full'
					),
					array(
						'label' => Translate::translate( 'Maximum Full Width' ),
						'value' => 'ex-full'
					),
				)
			);
			$map_override->setDescription(
				Translate::translate(
					'By default, the map will be given to the Visual Composer row. However, in some cases depending on your theme\'s CSS - it may not fit well to the container you are wishing it would. In that case you will have to select the appropriate value here that gets you desired output..'
				)
			);
			$this->addControl( $map_override );

			$map_style = new TextArea( 'map_style' );
			$map_style->setPosType( 'raw_html' );
			$map_style->setLabel( Translate::translate( 'Google Styled Map JSON' ) );
			$map_style->setGroup( Translate::translate( 'Styling' ) );
			$map_style->setDescription(
				Translate::translate(
					'<a target="_blank" href="http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html">Click here</a> to get the style JSON code for styling your map.'
				)
			);
			$this->addControl( $map_style );

			$el_class = new ExtraCss();
			$el_class->setGroup( Translate::translate( 'Styling' ) );
			$this->addControl( $el_class );

		}
	}
}
