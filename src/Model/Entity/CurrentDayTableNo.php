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

namespace Currency\Model\Entity;
use SilverZF2\Db\Entity\Entity;

/**
 *
 *
 * @property $tableNoId
 * @property $tableDate
 * @property $tableNo
 *
 * @category     Zend Framework 2
 * @package      Currency
 * @subpackage   Model\Entity
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class CurrentDayTableNo extends Entity
{
	/**
	 * @param int $id
	 *
	 * @return $this
	 * @access public
	 */
	public function setTableNoId($id)
	{
		$this->tableNoId = $id;
		return $this;
	}

	/**
	 * @return int
	 * @access public
	 */
	public function getTableNoId()
	{
		return $this->tableNoId;
	}

	/**
	 * @param string $date
	 *
	 * @return $this
	 * @access public
	 */
	public function setTableDate($date)
	{
		$this->tableDate = $date;
		return $this;
	}

	/**
	 * @return object DateTime
	 * @access public
	 */
	public function getTableDate()
	{
		return $this->tableDate;
	}

	/**
	 *
	 * @param string $tableNo
	 *
	 * @return $this
	 * @access public
	 */
	public function setTableNo($tableNo)
	{
		$this->tableNo = $tableNo;
		return $this;
	}

	/**
	 *
	 * @return string
	 * @access public
	 */
	public function getTableNo()
	{
		return $this->tableNo;
	}
}