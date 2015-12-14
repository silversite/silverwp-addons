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

namespace Currency\Model\Mapper;

use SilverZF2\Db\Mapper\AbstractDbMapper;

/**
 *
 *
 *
 * @category     Zend Framework 2
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class Currency extends AbstractDbMapper
{
	/**
	 * @var string
	 */
	protected $tableName = 'currency';

	/**
	 * @var array
	 */
	private $continent
		= [
			'Europa',
			'Ameryka Północna',
			'Ameryka Południowa',
			'Azja',
			'Australia',
			'Afryka'
		];

	public function getAll() {
		$select = $this->getSelect();

		return $this->select( $select );
	}

	public function getContinentNameById( $id ) {
		return $this->continent[ $id ];
	}

	/**
	 * Exchange data from currency table to WP posts table
	 *
	 * @param array  $data
	 * @param string $post_type
	 * @param string $taxonomy_name
	 *
	 * @return int
	 * @access public
	 */
	public function export2Wp(array $data, $post_type = 'currency', $taxonomy_name = 'currency_continent')
	{
		global $wpdb;
		$term = get_term_by( 'name', $this->getContinentNameById( $data['currency_continent'] ), 'currency_continent' );
		$slug = sanitize_title($data['currency_symbol']);
		$post      = array(
			'ID'            => $data['currency_id'],
			'post_content'  => '',
			'post_title'    => $data['currency_symbol'],
			'post_name'     => $slug,
			'post_type'     => $post_type,
			'post_date'     => date( 'Y-m-d H:i:s' ),
			'post_date_gmt' => date( 'Y-m-d H:i:s' ),
			'post_status'   => 'publish',
			'menu_order'    => $data['currency_order'],
			'guid'          => getenv('WP_HOME') . '/' . $slug,
//			'tax_input'     => [ $taxonomy_name => [ (int) $term->term_id ] ]
		);
		$postAttr = sanitize_post($post, 'db');
		unset($postAttr['filter']);

		$tableName = $this->getDbAdapter()->getTablePrefix() . 'posts';
		$wpdb->insert($tableName, $postAttr);
		$post_id = $wpdb->insert_id;

		if ( $post_id ) {
			$post_meta = [
				'description' => $data['currency_description'],
				'main_page'   => $data['currency_main_page'],
				'country'     => $data['currency_country'],
			];
			wp_set_object_terms( $post_id, $term->term_id, $taxonomy_name, true );
			add_post_meta( $post_id, '_silverwp_option_' . $post_type, $post_meta );
		}

		return $post_id;
	}
}