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
use SilverZF2\Db\ResultSet\EntityResultSet;


/**
 *
 * HistoryTableNoTrait Table no trait
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
trait HistoryTableNoTrait
{
	/**
	 * Get to day table no
	 *
	 * @access public
	 *
	 * @param string $date date format: YYYY-MM-DD
	 *
	 * @return EntityResultSet
	 */
	public function getTableNoByDate($date)
	{
		/** @var $select \Zend\Db\Sql\Select*/
		$select = $this->getSelect();
		$select->where->equalTo('table_date', $date);
		$select->limit(1);
		/** @var $result EntityResultSet*/
		$result = $this->select($select);

		return $result->current();
	}

	/**
	 * Get latest table no
	 *
	 * @return EntityResultSet
	 * @access public
	 */
	public function getLastTableNo()
	{
		/** @var $select \Zend\Db\Sql\Select*/
		$select = $this->getSelect();
		$select->order('table_date DESC');
		$select->limit(1);
		/** @var $result EntityResultSet*/
		$results = $this->select($select);

		return $results->current();
	}

	/**
	 * Get first table no
	 *
	 * @return EntityResultSet
	 * @access public
	 */
	public function getFirstTableNo()
	{
		/** @var $select \Zend\Db\Sql\Select*/
		$select = $this->getSelect();
		$select->order('table_date ASC');
		$select->where->isNotNull('table_no');
		$select->limit(1);
		/** @var $result EntityResultSet*/
		$result = $this->select($select);

		return $result->current();
	}

	/**
	 * @param null|int $offset
	 * @param null|int $limit
	 *
	 * @access public
	 * @return \SilverZF2\Db\ResultSet\EntityResultSet
	 */
	public function getAll($offset = null, $limit = null)
	{
		/** @var $select \Zend\Db\Sql\Select*/
		$select = $this->getSelect();
		if ( ! is_null($offset)) {
			$select->offset((int)$offset);
		}
		if ( ! is_null($limit)) {
			$select->limit((int)$limit);
		}
		$select->order('table_date DESC');
		$data = $this->select($select);

		return $data;
	}
}