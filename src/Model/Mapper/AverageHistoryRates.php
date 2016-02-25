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
		// SELECT * FROM history_current_day_rate
		// WHERE currency_date >= date_sub(NOW(), INTERVAL 1 YEAR)
		// ORDER BY FIELD (currency_id, 143,137);
		$select = $this->getSelect();
		$select
			->where->in('currency_id', $currenciesIds)
			->greaterThanOrEqualTo('currency_date', new Expression('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
		;
		$inIds = implode(',', $currenciesIds);
		$select->order([new Expression('FIELD (currency_id, '. $inIds .')'), 'currency_date DESC']);
		$results = $this->select($select);

		return $results;
	}

    /**
     * @param int $tableNoId
     *
     * @return \Currency\Model\Entity\HistoryTrait
     * @access public
     */
    public function getRatesByTableNoId($tableNoId)
    {
        $tablePrefix = $this->getDbAdapter()->getTablePrefix();
        /** @var $select \Zend\Db\Sql\Select*/
        $select = $this->getSelect();
        $dateColumn = $this->getDateColumn();
        //INNER JOIN sell_buy_table_no ON (DATE_FORMAT(table_date, '%Y-%m-%d') = DATE_FORMAT(currency_date, '%Y-%m-%d'))
        $select->join(
            $tablePrefix . 'current_day_table_no',
            new Expression('DATE_FORMAT(' . $dateColumn . ', \'%Y-%m-%d\') = DATE_FORMAT(table_date, \'%Y-%m-%d\')'),
            ['table_no', 'table_no_id']
        )
               ->join(
                   ['p' => $tablePrefix . 'posts'],
                   new Expression('p.ID = currency_id AND p.post_type = \'currency\''),
                   []
               )
        ;

        //AND table_no_id = ?
        $select->where(['table_no_id = ?' => (int) $tableNoId]);
        $select->order('menu_order ASC');
        /** @var $results \SilverZF2\Db\ResultSet\EntityResultSet */
        $results = $this->select($select);

        return $results;
    }

}