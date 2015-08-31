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
		$offset       = $this->getRequestData( 'offset', FILTER_SANITIZE_NUMBER_INT );
		$current_page = $this->getRequestData( 'currentpage', FILTER_SANITIZE_NUMBER_INT );
		$category_id  = $this->getRequestData( 'catid', FILTER_SANITIZE_STRING );
        $layout       = $this->getRequestData( 'layout', FILTER_SANITIZE_STRING );
        $limit        = get_option('posts_per_page');
        $offset       = $limit * $current_page;
        //Debug::dump($current_page, 'current_page');
        //Debug::dump($offset, 'offset');
        //Debug::dump($category_id, 'category');

		//create post type portfolio object
		$the_query = new Query();
		//if category id is set create tax query
		if ( $category_id && $category_id != '*' ) {
			$the_query->addTaxonomyFilter( 'category', (int) $category_id );
		}

		$the_query->setCurrentPagedPage( (int) $current_page );
        $the_query->setOffset( (int) $offset );

		$the_query->get_posts();

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
