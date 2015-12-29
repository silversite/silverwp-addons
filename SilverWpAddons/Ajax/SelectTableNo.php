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
 *
 * Create select with table no list
 *
 * @category   WordPress
 * @package    SilverWpAddons
 * @subpackage Ajax
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
class SelectTableNo extends AjaxAbstract {
	protected $name = 'select-table-no';

	/**
	 * ajax response
	 *
	 * @access public
	 */
	public function ajaxResponse() {
		$model = $this->getRequestData( 'model', FILTER_SANITIZE_STRING, 'currentDay');
		$page  =  $this->getRequestData( 'page', FILTER_SANITIZE_NUMBER_INT, 0);

		switch ($model) {
			case 'currentDay':
				/** @var $mapper \Currency\Model\Mapper\CurrentDayTableNo*/
				$mapper = \SilverWpAddons\get_service( 'TableNo' );
				break;
			case 'irredeemable':
				/** @var $mapper \Currency\Model\Mapper\IrredeemableTableNo*/
				$mapper = \SilverWpAddons\get_service( 'Mapper\IrredeemableTableNo' );
				break;

		}

		$tables = $mapper->findAll( $page, 100 );
		$data = [
			'total_count' => $mapper->countAll(),
		];
		foreach ( $tables as $table ) {
			$data['items'][] = [
				'id'   => $table->table_no_id,
				'no'   => $table->table_no,
			];
		}

		$this->responseJson($data);
	}
}