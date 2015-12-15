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
 *
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class CurrentDayRate extends AbstractDbMapper
{
	/**
	 * @var string
	 */
	protected $tableName = 'current_day_rate';

	/**
	 * @param bool $mainPageOnly get only currencies with flag display on main page. Default: false
	 * @param int  $limit display limit. Default: 10
	 *
	 * @return \Zend\Db\ResultSet\HydratingResultSet
	 * @access public
	 */
	public function getCurrentDayRate($mainPageOnly = false, $limit = 10)
	{
		//todo add auto prefix to table name
		$tablePrefix = $this->getDbAdapter()->getTablePrefix();

		$select = $this->getSql()->select()
			->columns([
				'current_day_rate_id',
				'currency_counter',
				'currency_rate',
				'currency_change_rate',
			    'currency_id'
			])
			->from($this->getTableName())
			->join(
				['p' => $tablePrefix . 'posts'],
				new Expression('p.ID = currency_id AND p.post_type = \'currency\''),
				['id'=> 'ID' , 'iso' => 'post_title']
			)
		;
		if ($mainPageOnly) {
			$select->join(
				['pm' => $tablePrefix . 'postmeta'],
				new Expression('p.ID = pm.post_id AND pm.meta_key = \'main_page\' AND pm.meta_value = 1'),
				[]
			);
		}

		if ($limit) {
			$select->limit($limit);
		}

		$results = $this->select($select);

		return $results;
	}
}