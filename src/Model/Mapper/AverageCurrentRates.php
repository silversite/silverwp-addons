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
use Zend\Db\Sql\Select;

/**
 *
 *
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class AverageCurrentRates extends AbstractDbMapper implements CurrentRatesInterface
{
	use CurrentRatesTrait;

	/**
	 * @var string
	 */
	protected $tableName = 'current_day_rate';

	/**
	 * @var string
	 */
	protected $pkColumn = 'current_day_rate_id';

	/**
	 * @param int $id
	 *
	 * @return bool|\SilverZF2\Db\Entity\Entity
	 * @access public
	 */
	public function getRatesByCurrencyId($id)
	{
		//todo add auto prefix to table name
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();
		$select = $this->getSelect();
//		$select->from(['cdr' => $this->tableName]);

		$tableName = $this->getTableName();

		$select->columns(
			[
				'counter' => 'currency_counter',
				'avg'     => 'currency_rate',
			]
		);
		$select->join(
			['cd' => $tablePrefix . 'currency_duty'],
			'cd.currency_id = ' . $tableName . '.currency_id',
			['duty' => 'currency_rate'],
			Select::JOIN_LEFT
		);
		$select->join(
			['sb' => $tablePrefix . 'currency_sell_buy'],
			'sb.currency_id = ' . $tableName . '.currency_id',
			['buy' => 'currency_buy_rate', 'sell' => 'currency_sell_rate'],
			Select::JOIN_LEFT
		);
		$select->where([$this->getTableName() . '.currency_id = ? ' => $id]);
		$select->order(['currency_date DESC']);
		$select->limit(1);
//		echo $this->getSqlQuery($select);
		return $this->select($select)->current();
	}
}