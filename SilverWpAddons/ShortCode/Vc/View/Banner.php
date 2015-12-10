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
namespace SilverWpAddons\ShortCode\Vc\View;

use SilverWp\ShortCode\Vc\Control\Animation;
use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\Link;
use SilverWp\ShortCode\Vc\Control\Image;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\ShortCode\Vc\View\ViewAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\View\Banner' ) ) {
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
	class Banner extends ViewAbstract {
		public function singleParamHtmlHolder( $param, $value ) {
			$output = '';
			// Compatibility fixes
			$old_names = array(
				'yellow_message',
				'blue_message',
				'green_message',
				'button_green',
				'button_grey',
				'button_yellow',
				'button_blue',
				'button_red',
				'button_orange'
			);
			$new_names = array(
				'alert-block',
				'alert-info',
				'alert-success',
				'btn-success',
				'btn',
				'btn-info',
				'btn-primary',
				'btn-danger',
				'btn-warning'
			);
			$value = str_ireplace( $old_names, $new_names, $value );
			//$value = esc_html__($value, "js_composer");
			//
			$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
			$type = isset( $param['type'] ) ? $param['type'] : '';
			$class = isset( $param['class'] ) ? $param['class'] : '';


			if ( 'attach_image' === $param['type'] && 'image' === $param_name ) {
				$output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';
				$element_icon = $this->settings( 'icon' );
				$img = wpb_getImageBySize( array(
					'attach_id' => (int) preg_replace( '/[^\d]/', '', $value ),
					'thumb_size' => 'thumbnail'
				) );
				$this->setSettings( 'logo', ( $img ? $img['thumbnail'] : '<img width="150" height="150" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail vc_element-icon"  data-name="' . $param_name . '" alt="" title="" style="display: none;" />' ) . '<span class="no_image_image vc_element-icon' . ( ! empty( $element_icon ) ? ' ' . $element_icon : '' ) . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '" /><a href="#" class="column_edit_trigger' . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '">' . esc_html__( 'Add image', 'js_composer' ) . '</a>' );
				$output .= $this->outputTitleTrue( $this->settings['name'] );
			} elseif ( ! empty( $param['holder'] ) ) {
				if ( $param['holder'] == 'input' ) {
					$output .= '<' . $param['holder'] . ' readonly="true" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '">';
				} elseif ( in_array( $param['holder'], array( 'img', 'iframe' ) ) ) {
					$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" src="' . $value . '">';
				} elseif ( $param['holder'] !== 'hidden' ) {
					$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
				}
			}

			if ( ! empty( $param['admin_label'] ) && $param['admin_label'] === true ) {
				$output .= '<span class="vc_admin_label admin_label_' . $param['param_name'] . ( empty( $value ) ? ' hidden-label' : '' ) . '"><label>' . esc_html__( $param['heading'], 'js_composer' ) . '</label>: ' . $value . '</span>';
			}

			return $output;
		}

		public function getImageSquereSize( $img_id, $img_size ) {
			if ( preg_match_all( '/(\d+)x(\d+)/', $img_size, $sizes ) ) {
				$exact_size = array(
					'width' => isset( $sizes[1][0] ) ? $sizes[1][0] : '0',
					'height' => isset( $sizes[2][0] ) ? $sizes[2][0] : '0',
				);
			} else {
				$image_downsize = image_downsize( $img_id, $img_size );
				$exact_size = array(
					'width' => $image_downsize[1],
					'height' => $image_downsize[2],
				);
			}
			if ( isset( $exact_size['width'] ) && (int) $exact_size['width'] !== (int) $exact_size['height'] ) {
				$img_size = (int) $exact_size['width'] > (int) $exact_size['height']
					? $exact_size['height'] . 'x' . $exact_size['height']
					: $exact_size['width'] . 'x' . $exact_size['width'];
			}

			return $img_size;
		}

		protected function outputTitle( $title ) {
			return '';
		}

		protected function outputTitleTrue( $title ) {
			return '<h4 class="wpb_element_title">' . esc_html__( $title, 'js_composer' ) . ' ' . $this->settings( 'logo' ) . '</h4>';
		}
	}
}
