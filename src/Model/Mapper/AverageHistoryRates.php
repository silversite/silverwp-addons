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
 * History average rates
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class AverageHistoryRates extends AbstractDbMapper
	implements HistoryInterface, HistoryTableNoInterface, ComparisonInterface
{
	use HistoryTrait;
	use HistoryTableNoTrait;

	/**
	 * @var string
	 */
	protected $tableName = 'history_current_day_rate';

	/**
	 * @var string
	 */
	protected $pkColumn = 'currency_id';

	/**
	 * @param array $currenciesIds
	 *
	 * @return \SilverZF2\Db\ResultSet\EntityResultSet
	 * @access public
	 */
	public function getComparisonRates(array $currenciesIds)
	{
		//SELECT * FROM history_current_day_rate WHERE currency_date >= date_sub(NOW(), INTERVAL 1 YEAR);
		$select = $this->getSelect();
		$select
			->where->in('currency_id', $currenciesIds)
			->greaterThanOrEqualTo('currency_date', new Expression('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
		;
		echo $this->getSqlQuery($select);
		$results = $this->select($select);

		return $results;
	}
}