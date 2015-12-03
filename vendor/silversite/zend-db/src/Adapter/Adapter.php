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

namespace SilverZF2\Db\Adapter;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Adapter\Profiler\ProfilerInterface;
use Zend\Db\ResultSet\ResultSetInterface;

/**
 *
 *
 *
 * @category   Zend Framework 2
 * @package    Db
 * @subpackage Adapter
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverZF2.pl 2015
 * @version    0.1
 */
class Adapter extends \Zend\Db\Adapter\Adapter
{
	/**
	 * @var string
	 */
	protected $tablePrefix = null;

	/**
	 * Adapter constructor.
	 *
	 * @see parent::__construct()
	 * @param array|\Zend\Db\Adapter\Driver\DriverInterface $driver
	 * @param Platform\PlatformInterface                    $platform
	 * @param ResultSet\ResultSetInterface                  $queryResultPrototype
	 * @param Profiler\ProfilerInterface                    $profiler
	 */
	public function __construct(
		$driver,
		PlatformInterface $platform = null,
		ResultSetInterface $queryResultPrototype = null,
		ProfilerInterface $profiler = null
	)
	{
		if ( is_array( $driver ) && isset( $driver['prefix'] ) ) {
			$this->setTablePrefix( $driver['prefix'] );
			unset($driver['prefix']);
		}
		parent::__construct($driver, $platform, $queryResultPrototype, $profiler);
	}

	/**
	 * @return string
	 */
	public function getTablePrefix() {
		return $this->tablePrefix;
	}

	/**
	 * @param sting $tablePrefix
	 *
	 * @return Adapter
	 */
	public function setTablePrefix( $tablePrefix ) {
		$this->tablePrefix = $tablePrefix;

		return $this;
	}
}