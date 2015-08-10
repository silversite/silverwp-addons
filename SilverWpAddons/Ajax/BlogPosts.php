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

/**
 * Blog posts list via ajax
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Revision: 2449 $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage Ajax
 * @copyright (c) SilverSite.pl 2015
 */
class BlogPosts extends AjaxAbstract {

	protected $name = 'blog-posts';
	protected $ajax_js_file = '';

	public function ajaxResponse() {
		$this->checkAjaxReferer();
		//get request params
		$limit		 = $this->getRequestData( 'limit', FILTER_SANITIZE_NUMBER_INT );
		$offset		 = $this->getRequestData( 'offset', FILTER_SANITIZE_NUMBER_INT );
		//$pager		 = $this->getRequestData( 'pagination', FILTER_VALIDATE_BOOLEAN );
		$category_id = $this->getRequestData( 'catid', FILTER_SANITIZE_NUMBER_INT );
		//create post type portfolio object
		$query_args = array();
		//if category id is set create tax query
		if ( $category_id && $category_id != '*' ) {
			$query_args = array(
				'tax_query' => array(
					array(
						'taxonomy'	 => 'category',
						'field'		 => 'term_id',
						'terms'		 => (int) $category_id,
					),
				),
			);
		}
		//if offset is set add paged param
		if ( $offset ) {
			$query_args[ 'offset' ] = (int) $offset;
		}

		$query_args[ 'numberposts' ] = (int) $limit;

		$items = \get_posts( \wp_parse_args( $query_args ) );

		$data = array(
			'data' => $items,
		);

		$view_file = $this->getViewFileFromRequest();
		$this->responseHtml( $data, $view_file );
	}

}
