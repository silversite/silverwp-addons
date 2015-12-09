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

namespace SilverZF2\Db\Entity;

use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\Hydrator\HydratorAwareInterface;
use Zend\Hydrator\HydratorAwareTrait;
use Zend\Hydrator\Iterator\HydratingArrayIterator;

/**
 *
 *
 *
 * @category   Zend Framework 2
 * @package    Db
 * @subpackage Entity
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
class Entity implements EntityInterface
{
	use HydratorAwareTrait;

	/**
	 * Check if field is already set
	 *
	 * @magic
	 *
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function __isset( $name )
	{
		return ( null !== $this->$name );
	}

	/**
	 * Returns value of field. Value will be obtained by getter if is present.
	 *
	 * @magic
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __get( $name )
	{
		$getter = 'get' . ucfirst( $name );
		$name   = $this->formatFieldName( $name );

		if ( method_exists( $this, $getter ) ) {
			return $this->$getter();
		} else {
			return $this->{$name};
		}
	}

	/**
	 * Sets value of field direct or by setter if is present.
	 *
	 * @magic
	 *
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @throws LogicException When trying to set primary key of non-new entity
	 */
	public function __set( $name, $value )
	{
		$setter = 'set' . ucfirst( $name );
		$name   = $this->formatFieldName( $name );

		if ( method_exists( $this, $setter ) ) {
			$this->$setter( $value );
		} else {
			$this->{$name} =  $value;
		}
	}

	/**
	 * Unsets field
	 *
	 * @magic
	 * @param string $name
	 */
	public function __unset($name)
	{
		$this->__set($name, null);
		unset($this->{$name});
	}

	/**
	 * Format column name
	 *
	 * @param  string $name
	 * @return string
	 * @access private
	 */
	private function formatFieldName($name)
	{
		static $instance = null;

		if (is_null($instance)) {
			$instance = new CamelCaseToUnderscore();
		}
		$name = strtolower( $instance->filter( $name ) );

		return $name;
	}
}