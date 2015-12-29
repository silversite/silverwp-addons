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
 * Create select with days list
 *
 * @category   WordPress
 * @package    SilverWpAddons
 * @subpackage Ajax
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
class SelectDay extends AjaxAbstract {

	/**
	 * ajax response
	 *
	 * @access public
	 */
	public function ajaxResponse() {
		$model = $this->getRequestData( 'model', FILTER_SANITIZE_STRING, 'currentDay');
		$year =  $this->getRequestData( 'year', FILTER_SANITIZE_NUMBER_INT, date('Y'));
		$month =  $this->getRequestData( 'month', FILTER_SANITIZE_NUMBER_INT, date('m'));

		switch ($model) {
			case 'currentDay':
				/** @var $mapper \Currency\Model\Mapper\HistoryCurrentDayRate*/
				$mapper = \SilverWp\Service\get_service( 'Mapper\HistoryCurrentDayRate' );
				break;
			case 'sellBuy':
				/** @var $mapper \Currency\Model\Mapper\HistorySellBuy*/
				$mapper = \SilverWp\Service\get_service( 'Mapper\HistorySellBuy' );
				break;
			case 'currentDay':
				/** @var $mapper \Currency\Model\Mapper\HistoryIrredeemable*/
				$mapper = \SilverWp\Service\get_service( 'Mapper\HistoryIrredeemable' );
				break;

		}

		$data = $mapper->getDaysByYearMonth($year, $month);
		$this->responseJson(['data' => $data->toArray()]);
	}
}