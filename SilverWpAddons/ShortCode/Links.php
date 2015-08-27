<?php
/*
 * Copyright (C) 2014 Marcin Dobroszek <marcin at silversite.pl>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace SilverWpAddons\ShortCode;

use SilverWp\ShortCode\Vp\Menu\Element\ElementAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Links' ) ) {
	/**
	 *
	 * Links short code
	 *
	 * @author     Marcin Dobroszek <marcin at silversite.pl>
	 * @category   WordPress
	 * @package    SilverWpAddons
	 * @subpackage ShortCode
	 * @copyright  SilverSite.pl (c) 2015
	 * @version    $Revision:$
	 */
	class Links extends ElementAbstract {
		protected $tag_base = 'links';

		/**
		 * Render content
		 *
		 * @param array  $args
		 * @param string $content
		 *
		 * @return string
		 * @access public
		 */
		public function content( $args, $content = '' ) {
            var_dump($args);
			$data = array(
				'args'    => $args,
				'content' => $content,
			);

			$output = $this->render( $data );

			return $output;
		}
	}
}