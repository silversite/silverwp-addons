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

	public function getRatesByCurrencyId($id)
	{
		//todo add auto prefix to table name
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();
		/*
		 * SELECT
cdr.currency_counter, cdr.currency_id, currency_date,
cdr.currency_rate AS current_rate,
cd.currency_rate AS duty_rate,
sb.currency_buy_rate, sb.currency_sell_rate,
ci.currency_counter AS irredeemable_counter,
ci.currency_rate AS irredeemable_rate
FROM `waluty__current_day_rate` AS cdr
LEFT JOIN `waluty__currency_duty` AS `cd` ON cd.currency_id = cdr.currency_id
LEFT JOIN `waluty__currency_sell_buy` AS `sb` ON sb.currency_id = cdr.currency_id
LEFT JOIN `waluty__currency_irredeemable` AS `ci` ON ci.currency_id = cdr.currency_id
WHERE
cdr.currency_id = 143
ORDER BY currency_date DESC
LIMIT 1
		 */
		$select = $this->getSelect();
//		$select->from(['cdr' => $this->tableName]);
		$select->columns(
			[
				'counter' => 'currency_counter',
				'avg'     => 'currency_rate',
			]
		);
		$select->join(
			['cd' => $tablePrefix . 'currency_duty'],
			'cd.currency_id = ' . $this->getTableName() . '.currency_id',
			['duty' => 'currency_rate'],
			Select::JOIN_LEFT
		);
		$select->join(
			['sb' => $tablePrefix . 'currency_sell_buy'],
			'sb.currency_id = ' . $this->getTableName() . '.currency_id',
			['buy' => 'currency_buy_rate', 'sell' => 'currency_sell_rate'],
			Select::JOIN_LEFT
		);
		$select->join(
			['ci' => $tablePrefix . 'currency_irredeemable'],
			'ci.currency_id = ' . $this->getTableName() . '.currency_id',
			['irredeemable_counter' => 'currency_counter', 'irredeemable_rate' => 'currency_rate'],
			Select::JOIN_LEFT
		);
		$select->where([$this->getTableName() . '.currency_id = ? ' => $id]);
		$select->order(['currency_date DESC']);
		$select->limit(1);

		return $this->select($select)->current();
	}
}