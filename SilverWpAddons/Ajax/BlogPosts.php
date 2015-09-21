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

/**
 * Blog posts list via ajax
 *
 * @author        Michal Kalkowski <michal at silversite.pl>
 * @version       1.0
 * @category      WordPress
 * @package       SilverWpAddons
 * @subpackage    Ajax
 * @copyright     SilverSite.pl (c) 2015
 */
class BlogPosts extends AjaxAbstract {

	protected $name = 'blogposts';
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
		$args = array();
		$offset       = $this->getRequestData(
			'offset',
			FILTER_SANITIZE_NUMBER_INT
		);
		$current_page = $this->getRequestData(
			'currentpage',
			FILTER_SANITIZE_NUMBER_INT
		);
		$filter_name  = $this->getRequestData(
			'filtername',
			FILTER_SANITIZE_STRING
		);
		$filter_value = $this->getRequestData(
			'filtervalue',
			FILTER_SANITIZE_NUMBER_INT
		);
		$layout       = $this->getRequestData(
			'layout',
			FILTER_SANITIZE_STRING
		);
		$ignore_sticky = $this->getRequestData(
			'ignoresticky',
			FILTER_SANITIZE_NUMBER_INT
		);

		$limit = $this->getRequestData(
			'limit',
			FILTER_SANITIZE_NUMBER_INT,
			get_option( 'posts_per_page' )
		);
		$args['posts_per_page'] = $limit;

		if ( $ignore_sticky == 1 ) {
			$args['ignore_sticky_posts'] = 1;
		}


		//if category id is set create tax query
		switch ( $filter_name ) {
			case 'cat':
				$args = array(
					'post_type' => 'post',
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'category',
							'field'    => 'term_id',
							'terms'    => $filter_value,
						),
					),
				);
				break;
			case 'tag':
				$args = array(
					'post_type' => 'post',
					'tag_id'    => (int) $filter_value
				);
				break;
			case 'author':
				$args['author'] = (int) $filter_value;
				break;
			case 'date':
				//todo this doesn't work
				$args = array(
					'post_type' => 'post',
				);
				if ( get_option( 'permalink_structure' ) ) {
					$date = explode('/', $filter_value);
					if (isset($date[0])) {
						$args['date_query']['year'] = $date[0];
					}
					if (isset($date[1])) {
						$args['date_query']['month'] = $date[1];
					}
					if (isset($date[2])) {
						$args['date_query']['day'] = $date[2];
					}
				}
				break;
		}

		$the_query = new Query( $args );
		$the_query->setMetaBox( Blog::getInstance() );
		//add + 1 because load more hav to go to next page but from request
		// I got current page
		$current_page = (int) $current_page + 1;
		$the_query->setCurrentPagedPage( $current_page );
		if ( ! $offset ) {
			$offset = ( $current_page - 1 ) * $limit;
		}
		//if offset is set add paged param
		if ( $offset ) {
			$the_query->setOffset( (int) $offset );
		}

		$the_query->get_posts();
//		Debug::dumpPrint($the_query);
		$data = array(
			'the_query' => $the_query,
			'args'      => array(
				'layout' => $layout,
			)
		);

		$this->responseHtml( $data );

		$the_query->reset_postdata();
	}
}
