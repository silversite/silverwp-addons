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
use Zend\Db\Sql\Expression;

/**
 *
 * History current day rates
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class HistoryCurrentDayRate extends AbstractDbMapper implements HistoryInterface
{
	use HistoryTrait;
	/**
	 * @var string
	 */
	protected $tableName = 'history_current_day_rate';

	/**
	 * @param int $tableNoId
	 *
	 * @return \Currency\Model\Entity\HistoryCurrentDayRate
	 * @access public
	 */
	public function getRatesByTableNoId($tableNoId)
	{
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();
		/** @var $select \Zend\Db\Sql\Select*/
		$select = $this->getSelect();
		$dateColumn = $this->getDateColumn();
		//INNER JOIN current_day_table_no ON (DATE_FORMAT(table_date, '%Y-%m-%d') = DATE_FORMAT(currency_date, '%Y-%m-%d'))
		$select->join(
			$tablePrefix . 'current_day_table_no',
			new Expression('DATE_FORMAT(' . $dateColumn . ', \'%Y-%m-%d\') = DATE_FORMAT(table_date, \'%Y-%m-%d\')'),
			['table_no']
		);
		//AND table_no_id = ?
		$select->where(['table_no_id = ?' => (int) $tableNoId]);
		/** @var $results \SilverZF2\Db\ResultSet\EntityResultSet */
		$results = $this->select($select);

		return $results;
	}

	/**
	 * @param int $currencyId
	 * @param int $period
	 *
	 * @return \Currency\Model\Entity\HistoryCurrentDayRate
	 *
	 * @access public
	 */
	public function getRatesByCurrencyIdByPeriod($currencyId, $period)
	{
		//TODO move to SQL class
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();
		/** @var $select \Zend\Db\Sql\Select */
		$select     = $this->getSelect();
		$dateColumn = $this->getDateColumn();
		//AND currency_id = ?
		$select->where(['currency_id = ?' => (int) $currencyId]);
		//INNER JOIN current_day_table_no ON (DATE_FORMAT(table_date, '%Y-%m-%d') = DATE_FORMAT(currency_date, '%Y-%m-%d'))
		$select->join(
			$tablePrefix . 'current_day_table_no',
			new Expression('DATE_FORMAT(' . $dateColumn . ', \'%Y-%m-%d\') = DATE_FORMAT(table_date, \'%Y-%m-%d\')'),
			['table_no']
		);
		//currency_date BETWEEN DATE(NOW() - INTERVAL  DAY) AND NOW()
		$select->where->between('currency_date', new Expression('DATE(NOW() - INTERVAL ? DAY)', $period), new Expression('NOW()'));
		/** @var $results \Currency\Model\Entity\HistoryCurrentDayRate */
		$results = $this->select($select);

		return $results;
	}

	/**
	 * @param int         $currencyId
	 * @param null|string $dateFrom - format: Y-m-d
	 * @param null|string $dateTo   - format: Y-m-d
	 *
	 * @return \Currency\Model\Entity\HistoryCurrentDayRate
	 * @access public
	 */
	public function getRatesByCurrencyIdByDates($currencyId, $dateFrom = null, $dateTo = null)
	{
		//TODO move to SQL class
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();
		/** @var $select \Zend\Db\Sql\Select */
		$select     = $this->getSelect();
		$dateColumn = $this->getDateColumn();
		//AND currency_id = ?
		$select->where(['currency_id = ?' => (int) $currencyId]);
		//INNER JOIN current_day_table_no ON (DATE_FORMAT(table_date, '%Y-%m-%d') = DATE_FORMAT(currency_date, '%Y-%m-%d'))
		$select->join(
			$tablePrefix . 'current_day_table_no',
			new Expression('DATE_FORMAT(' . $dateColumn . ', \'%Y-%m-%d\') = DATE_FORMAT(table_date, \'%Y-%m-%d\')'),
			['table_no']
		);
		if ( ! is_null($dateFrom) && ! is_null($dateTo)) {
			//currency_date BETWEEN $dateFrom AND $dateTo
			$select->where->between(
				'currency_date',
				new Expression('?', $dateFrom),
				new Expression('?', $dateTo)
			);
		} elseif ( ! is_null($dateFrom)) {
			//currency_date <= $dateFrom
			$select->where->greaterThanOrEqualTo('currency_date', new Expression('?', $dateFrom));
		} elseif ( ! is_null($dateTo)) {
			//currency_date >= $dateTo
			$select->where->lessThanOrEqualTo('currency_date', new Expression('?', $dateTo));
		}

		/** @var $results \Currency\Model\Entity\HistoryCurrentDayRate */
		$results = $this->select($select);

		return $results;
	}
}