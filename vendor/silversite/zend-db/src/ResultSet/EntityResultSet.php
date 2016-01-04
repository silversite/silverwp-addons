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

namespace SilverZF2\Db\ResultSet;

use SilverWp\Debug;
use SilverZF2\Db\Entity\Entity;
use SilverZF2\Db\Entity\EntityAwareTrait;
use Zend\Db\ResultSet\AbstractResultSet;
use Zend\Hydrator\HydratorAwareTrait;
use Zend\Hydrator\HydratorInterface;

/**
 *
 * Entity result set
 *
 * @category   Zend Framework 2
 * @package    SilverZF2\Db
 * @subpackage ResultSet
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
class EntityResultSet extends AbstractResultSet
{
	use EntityAwareTrait;
	use HydratorAwareTrait;

	/**
	 * EntityResultSet constructor.
	 *
	 * @param string            $entityClass
	 * @param HydratorInterface $hydrator
	 *
	 * @access public
	 */
	public function __construct($entityClass, HydratorInterface $hydrator = null)
	{
		$this->setEntityClass($entityClass);

		if ( ! is_null($hydrator)) {
			$this->setHydrator($hydrator);
		}
	}

	/**
	 * @return bool|Entity
	 * @access public
	 */
	public function current()
	{
		if ($this->buffer === null) {
			$this->buffer = - 2;
		} elseif (
			is_array( $this->buffer)
		    && isset($this->buffer[$this->position])
		) {
			return $this->buffer[$this->position];
		}

		$data = $this->dataSource->current();

		if (is_array($data)) {
			$entity = $this->loadEntity($data);
			if ($this->hydrator) {
				$entity = $this->hydrator->hydrate($data, $entity);
			}
		} else {
			$entity = false;
		}

		if (is_array($this->buffer) ) {
			$this->buffer[$this->position] = $entity;
		}

		return $entity;
	}

	/**
	 * Convert to array with entity objects
	 *
	 * @return Entity[]
	 * @access public
	 */
//	public function toArray()
//	{
//		$return = [];
//		Debug::dumpPrint($this);
//		foreach ($this as $row) {
//			$return[] = $this->getHydrator()->extract($row);
//		}
//
//		return $return;
//	}
}