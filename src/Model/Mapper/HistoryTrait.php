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
		if ($this->tableName == 'history_currency_sell_buy') {
			$dateColumn = 'currency_insert_date';
		} else {
			$dateColumn = 'currency_date';
		}
		$select->columns(['day' => new Expression('DATE_FORMAT(' . $dateColumn . ', \'%d\')')])
			->where->equalTo(new Expression('YEAR(' . $dateColumn . ')'), (int)$year)
			->and->equalTo(new Expression('MONTH(' . $dateColumn . ')'), $month);
		;
		$select->group(new Expression('DAY(' . $dateColumn . ')'));
		$results = $this->select($select);

		return $results;
	}
}