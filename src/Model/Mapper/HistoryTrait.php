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
use Zend\Db\Sql\Expression;


/**
 *
 * History mapper Trait
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
trait HistoryTrait
{
	protected $currencyId;
	protected $dateFrom;
	protected $dateTo;

	/**
	 * Get all list of days from year and month
	 *
	 * @param int $year
	 * @param int $month
	 *
	 * @return \SilverZF2\Db\ResultSet\EntityResultSet
	 * @access public
	 */
	public function getDaysByYearMonth($year, $month)
	{
		/** @var  $select \Zend\Db\Sql\Select*/
		$select = $this->getSelect();
		$dateColumn = $this->getDateColumn();

		$select->columns(['day' => new Expression('DATE_FORMAT(' . $dateColumn . ', \'%d\')')])
			->where->equalTo(new Expression('YEAR(' . $dateColumn . ')'), (int)$year)
			->and->equalTo(new Expression('MONTH(' . $dateColumn . ')'), $month);
		;
		$select->group(new Expression('DAY(' . $dateColumn . ')'));
		$results = $this->select($select);

		return $results;
	}

	public function getCurrencyRates($currencyId, $dateFrom = null, $dateTo = null, $tableNoId = null)
	{
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();
		/** @var $select \Zend\Db\Sql\Select*/
		$select = $this->getSelect();
		$dateColumn = $this->getDateColumn();
		$select->where(['currency_id = ?' => (int) $currencyId]);

		if ( ! is_null($dateFrom) && ! is_null($dateTo)) {
			//currency_date BETWEEN ($dateFrom AND $dateTo)
			$select->where->between($dateColumn, $dateFrom, $dateTo);
		} else if ( ! is_null($dateFrom)) {
			//currency_date <= $dateFrom
			$select->where->lessThanOrEqualTo($dateColumn, $dateFrom);
		} else if ( ! is_null($dateTo)) {
			//currency_date >= $dateTo
			$select->where->greaterThanOrEqualTo($dateColumn, $dateTo);
		}

		if ( ! is_null($tableNoId)) {
			//INNER JOIN current_day_table_no ON (DATE_FORMAT(table_date, '%Y-%m-%d') = DATE_FORMAT(currency_date, '%Y-%m-%d'))
			$select->join($tablePrefix . 'current_day_table_no', new Expression('DATE_FORMAT(table_date, \'%Y-%m-%d\') = DATE_FORMAT(currency_date, \'%Y-%m-%d\')'));
			//AND table_no_id = ?
			$select->where(['table_no_id = ?' => (int) $tableNoId]);
		}
		/** @var $results \SilverZF2\Db\ResultSet\EntityResultSet */
		$results = $this->select($select);
		echo $this->getSqlQuery($select);
		return $results;
	}

	/**
	 * Get date column name by table name
	 *
	 * @return string
	 * @access private
	 */
	private function getDateColumn()
	{
		if ($this->tableName == 'history_currency_sell_buy') {
			$dateColumn = 'currency_insert_date';
		} else {
			$dateColumn = 'currency_date';
		}
		return $dateColumn;
	}
}