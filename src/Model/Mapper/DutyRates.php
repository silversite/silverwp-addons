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
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Where;

/**
 *
 *
 * @property int $currency_duty_id
 * @property int $currency_publication_date
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class DutyRates extends AbstractDbMapper implements CurrentRatesInterface, HistoryInterface
{
	use CurrentRatesTrait {
		getRates as parentRates;
	}

	use HistoryTrait;

	/**
	 * @var string
	 */
	protected $tableName = 'currency_duty';

	/**
	 * @var string
	 */
	protected $pkColumn = 'currency_duty_id';

	/**
	 * @param bool $mainPageOnly
	 * @param bool $limit
	 *
	 * @return \Currency\Model\Entity\CurrentRatesTrait
	 * @access public
	 */
	public function getRates($mainPageOnly = false, $limit = false, $date = null)
	{
		if (is_null($date)) {
			$date = date('Y-m');
		}
		$where = new Where();
		$where->equalTo(new Expression('DATE_FORMAT(\'currency_publication_date\', \'%Y-%m\')'), $date);
		$data = $this->parentRates($mainPageOnly, $limit, $where);
		return $data;
	}

	public function getLastPublicationDate()
	{
		$select = $this->getSelect();
		$select->columns(['publication']);
	}
}