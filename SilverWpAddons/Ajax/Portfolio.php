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

use SilverWpAddons\PostType;
use SilverWp\Ajax\AjaxAbstract;

/**
 * Portfolio projects
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Revision:$
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage Ajax
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */
class Portfolio extends AjaxAbstract {

	protected $name = 'portfolio';

	public function ajaxResponse() {
		$this->checkAjaxReferer();
		//get request params
		$limit		 = $this->getRequestData( 'limit', FILTER_SANITIZE_NUMBER_INT );
		$offset		 = $this->getRequestData( 'offset', FILTER_SANITIZE_NUMBER_INT );
		$pager		 = $this->getRequestData( 'pagination', FILTER_VALIDATE_BOOLEAN );
		$category_id = $this->getRequestData( 'catid', FILTER_SANITIZE_NUMBER_INT );
		//create post type portfolio object
		$Portfolio	 = PostType\Portfolio::getInstance();

		$query_args = array();
		//if category id is pased create tax query
		if ( $category_id && $category_id != '*' ) {
			$query_args = array(
				'tax_query' => array(
					array(
						'taxonomy'	 => $Portfolio->getTaxonomy()->getName( 'category' ),
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
		$items = $Portfolio->getQueryData( $limit, $pager, $query_args );

		$data = array(
			'data' => $items,
		);
		//add pager links
		if ( $Portfolio->isPaginator() ) {
			//@todo move this to Ajax paginator class
			$big	 = 999999999;
			$base	 = \str_replace( $big, '%#%', \esc_url( \get_pagenum_link( $big ) ) );

			$args			 = array(
				'base'		 => $base,
				'format'	 => '/page/%#%',
				'total'		 => $Portfolio->getPaginator()->getTotalPosts(),
				'current'	 => $Portfolio->getPaginator()->getCurrentPage(),
				'show_all'	 => false,
				'end_size'	 => 1,
				'mid_size'	 => 2,
				'prev_next'	 => true,
				'prev_text'	 => '<i class="fa fa-angle-left"></i>',
				'next_text'	 => '<i class="fa fa-angle-right"></i>',
				'type'		 => 'array',
			//'add_args'     => array(),
			//'add_fragment' => '',
			);
			$data[ 'pager' ]	 = \paginate_links( $args );
		}
		$view_file = $this->getViewFileFromRequest();
		$this->responseHtml( $data, $view_file );
	}

}
