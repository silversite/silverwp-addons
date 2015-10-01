<?php

/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
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

namespace SilverWpAddons\Ajax;

use SilverWp\Ajax\AjaxAbstract;
use SilverWp\Db\Query;
use SilverWp\Debug;
use SilverWpAddons\MetaBox\Blog;

if ( ! class_exists( 'SilverWpAddons\Ajax\MegaMenu' ) ) {
	/**
	 * Mega menu post list from category (via ajax)
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       1.0
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    Ajax
	 * @copyright     SilverSite.pl (c) 2015
	 */
	class MegaMenu extends AjaxAbstract {

		protected $name = 'megamenu';
		protected $ajax_js_file = 'main.js';
		protected $ajax_handler = 'sage_js';

		/**
		 * Generate response
		 *
		 * @access public
		 */
		public function ajaxResponse() {
			$this->checkAjaxReferer();
			//get request params
			$category_id = $this->getRequestData(
				'cat',
				FILTER_SANITIZE_NUMBER_INT
			);
			if ( $category_id ) {
				//if category id is set create tax query
				$args      = array(
					'post_type' => 'post',
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'category',
							'field'    => 'term_id',
							'terms'    => array( $category_id ),
						),
					),
				);
				$the_query = new Query( $args );
				$the_query->setMetaBox( Blog::getInstance() );
				$the_query->get_posts();
				$data = array(
					'the_query' => $the_query,
					'args'      => array(
						'category_id' => $category_id,
					)
				);

				$this->responseHtml( $data );

				$the_query->reset_postdata();
			}
		}
	}
}