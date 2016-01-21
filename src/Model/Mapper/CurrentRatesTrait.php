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

use SilverWp\Debug;
use SilverZF2\Db\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;

/**
 *
 * @property int       $currency_id
 * @property \DateTime $currency_date
 * @property string    $currency_iso
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
trait CurrentRatesTrait
{
	/**
	 *
	 * @param bool     $mainPageOnly
	 * @param bool|int $limit
	 *
	 * @param Where    $where
	 *
	 * @return \Currency\Model\Entity\CurrentRatesTrait
	 * @access public
	 */
	public function getRates($mainPageOnly = false, $limit = false, Where $where = null)
	{
		//todo add auto prefix to table name
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();

		$select = $this->getSql()->select()
			->from($this->getTableName())
			->join(
				['p' => $tablePrefix . 'posts'],
				new Expression('p.ID = currency_id AND p.post_type = \'currency\''),
				['currency_id' => 'ID' , 'currency_iso' => 'post_title']
			)
		;

		$select->order('menu_order ASC');

		if ($mainPageOnly) {
			$select->join(
				['pm' => $tablePrefix . 'postmeta'],
				new Expression('p.ID = pm.post_id AND pm.meta_key = \'main_page\' AND pm.meta_value = 1'),
				[]
			);
		}

		if ( ! is_null($where)) {
			$select->where($where);
		}

		if ($limit) {
			$select->limit($limit);
		}

		$results = $this->select($select);
//		Debug::dump($this->getSqlQuery($select));
		return $results;
	}

	/**
	 * Get currencies list for table
	 *
	 * @return Currency
	 * @access public
	 */
	public function getCurrencies()
	{
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();
		//SELECT currency_id FROM $tableName INNER JOIN waluty__posts ON (ID=currency_id) GROUP BY currency_id
		$select = $this->getSelect();
		$select
			->columns(['currency_id'])
			->join(['p' => $tablePrefix. 'posts'], 'p.ID = currency_id', ['post_title','id' => 'ID'])
			->join(['c' => $tablePrefix. 'currency'], 'p.ID = c.currency_id', [])
			->group('currency_id')
			->order('menu_order ASC')

		;
		$results = $this->select($select);

		return $results;
	}
}