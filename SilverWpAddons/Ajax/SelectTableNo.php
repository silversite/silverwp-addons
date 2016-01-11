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

use Currency\Model\Entity\TableNoInterface;
use SilverWp\Ajax\AjaxAbstract;
use SilverZF2\Db\ResultSet\EntityResultSet;

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
	/**
	 * @var string
	 */
	protected $name = 'selectTableNo';

	/**
	 * ajax response
	 *
	 * @access public
	 */
	public function ajaxResponse() {
		$model = $this->getRequestData( 'model', FILTER_SANITIZE_STRING, 'currentDay' );
		$page  = $this->getRequestData( 'page', FILTER_SANITIZE_NUMBER_INT, 1 );
		$limit = $this->getRequestData( 'limit', FILTER_SANITIZE_NUMBER_INT, 5 );

		switch ( $model ) {
			case 'currentDay':
				/** @var $mapper \Currency\Model\Mapper\AverageTableNo */
				$mapper = \SilverWpAddons\get_service( 'Mapper\AverageTableNo' );
				break;
			case 'sellBuy':
				/** @var $mapper \Currency\Model\Mapper\SellBuyTableNo */
				$mapper = \SilverWpAddons\get_service( 'Mapper\SellBuyTableNo' );
				break;
			case 'irredeemable':
				/** @var $mapper \Currency\Model\Mapper\IrredeemableTableNo */
				$mapper = \SilverWpAddons\get_service( 'Mapper\IrredeemableTableNo' );
				break;

		}
		$count               = $mapper->countAll();
		$offset              = ( $page - 1 ) * $limit;
		$tables              = $mapper->getAll( $offset, $limit );
		$data                = $this->responseFormat( $tables );
		$data['total_count'] = [ $count ];

		$this->responseJson( $data );
	}

	/**
	 * @param EntityResultSet $tables
	 *
	 * @return array
	 * @access protected
	 */
	protected function responseFormat( EntityResultSet $tables ) {
		$return = [];
		/** @var $table TableNoInterface*/
		foreach ( $tables as $table ) {
			$return['items'][] = [
				'id'           => $table->table_no_id,
				'main_txt'     => $table->table_no,
				'info_txt'     => $table->getTableDate()->format('d-m-Y'),
				'flag_ico_url' => null
			];
		}
		return $return;
	}
}