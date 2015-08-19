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
	class GoogleMaps extends ShortCodeAbstract {
		protected $tag_base = 'ss_gm';

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
			$this->setLabel( Translate::translate( 'Google Map' ) );
			$this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );
			$this->setCssClass( 'vc_google_map' );
			$this->setDescription( Translate::translate( 'Display Google Maps to indicate your location' ) );
			$this->setIcon( 'vc_google_map' );


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

			$select = new Select( 'map_type' );
			$select->setLabel( Translate::translate( 'Map type' ) );
			$select->setAdminLabel( true );
			$select->setGroup( Translate::translate( 'General Settings' ) );
			$select->setOptions(
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

			$slider = new Slider( 'zoom' );
			$slider->setLabel( Translate::translate( 'Map Zoom' ) );
			$slider->setMin( 1 );
			$slider->setMax( 20 );
			$slider->setStep( 1 );
			$slider->setDefault( 18 );
			$slider->setGroup( Translate::translate( 'General Settings' ) );
			$this->addControl( $slider );

			$checkbox = new Checkbox( 'scrollwheel' );
			$checkbox->setLabel( '' );
			$checkbox->setGroup( Translate::translate( 'General Settings' ) );
			$checkbox->setOptions(
				array(
					array(
						'label' => Translate::translate( 'Disable map zoom on mouse wheel scroll' ),
						'value' => 'disable'
					)
				)
			);
			$this->addControl( $checkbox );

			$select = new Select( 'scrollwheel' );
			$select->setLabel( Translate::translate( 'Street view control' ) );
			$select->setGroup( Translate::translate( 'General Settings' ) );
			$select->setOptions(
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
			$this->addControl( $select );

			$select = new Select( 'maptypecontrol' );
			$select->setLabel( Translate::translate( 'Map type control' ) );
			$select->setGroup( Translate::translate( 'General Settings' ) );
			$select->setOptions(
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
			$this->addControl( $select );

			$select = new Select( 'pancontrol' );
			$select->setLabel( Translate::translate( 'Map pan control' ) );
			$select->setGroup( Translate::translate( 'General Settings' ) );
			$select->setOptions(
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
			$this->addControl( $select );

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
			$icon_img->setAdminLabel( true );
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
			$map_override->setDescription( Translate::translate( 'By default, the map will be given to the Visual Composer row. However, in some cases depending on your theme\'s CSS - it may not fit well to the container you are wishing it would. In that case you will have to select the appropriate value here that gets you desired output..' ) );
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
			$el_class->setGroup( Translate::translate( 'General Settings' ) );
			$this->addControl( $el_class );
		}
	}
}
