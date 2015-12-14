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

use Currency\Model\Entity;
use SilverZF2\Db\Mapper\AbstractDbMapper;

/**
 * Current day table no
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class CurrentDayTableNo extends AbstractDbMapper
{
	/**
	 * @var string
	 */
	protected $tableName = 'current_day_table_no';

	/**
	 * Get to day table no
	 *
	 * @access public
	 *
	 * @param string $date date format: YYYY-MM-DD
	 *
	 * @return \Zend\Db\ResultSet\HydratingResultSet
	 */
	public function getTableNoByDate($date)
	{
		$select = $this->getSelect();
		$select->where->equalTo('table_date', $date);
		$select->limit(1);
		$result = $this->select($select, new Entity\CurrentDayTableNo());

		return $result->current();
	}

	public function getLastTableNo()
	{
		$select = $this->getSelect();
		$select->order('table_date DESC');
		$select->limit(1);
		$result = $this->select($select, new Entity\CurrentDayTableNo());
		return $result->current();
	}
}