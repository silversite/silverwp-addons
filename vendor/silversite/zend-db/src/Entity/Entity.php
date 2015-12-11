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

/**
 *
 * Base Entity class
 *
 * @category   Zend Framework 2
 * @package    SilverZF2\Db
 * @subpackage Entity
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
class Entity implements EntityInterface
{
	/**
	 * @var string
	 */
	protected $rowPrefix = '';

	/**
	 * @var array
	 */
	protected $data = [];

	/**
	 * @var array
	 */
	protected $nullable = [];

	/**
	 * Check if field is already set
	 *
	 * @magic
	 *
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function __isset($name)
	{
		return (null !== $this->data[$name]);
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
	public function __get($name)
	{
		$getter = 'get' . ucfirst($name);
		$name   = $this->formatFieldName($name);
		if (method_exists($this, $getter)) {
			return $this->$getter();
		} else {
			return $this->_get($name);
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
	public function __set($name, $value)
	{
		$setter = 'set' . ucfirst($name);
		$name   = $this->formatFieldName($name);

		if (method_exists($this, $setter)) {
			$this->$setter($value);
		} else {
			$this->_set($name, $value);
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
		unset($this->data[$name]);
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
		$name = $this->getColumnName($name);
		$name = strtolower($instance->filter($name));

		return $name;
	}

	/**
	 * Gets value of specified filed or null
	 *
	 * @internal
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	protected function _get($name)
	{
		$name = $this->getColumnName($name);

		$value = isset($this->data[$name]) ? $this->data[$name] : null;

		return $value;
	}

	/**
	 * Sets value of specified field and optionally marks that field that is changed
	 *
	 * @internal
	 *
	 * @param string $name
	 * @param mixed  $value
	 */
	protected function _set($name, $value)
	{
		$name = $this->getColumnName($name);

		if ($this->isNullable($name) && $value !== 0 && empty($value)) {
			$value = null;
		}

		$this->data[$name] = $value;
	}

	/**
	 * Get column name with prefix if is set
	 *
	 * @param string $columnName
	 *
	 * @return string
	 */
	private function getColumnName($columnName)
	{
		if ( ! empty($this->rowPrefix)) {
			$columnName = ucfirst($this->rowPrefix) . ucfirst($columnName);
		}

		return $columnName;
	}

	/**
	 * Check the given column can be null
	 *
	 * @param string $column column name
	 *
	 * @return bool
	 * @access protected
	 */
	public function isNullable($column)
	{
		return in_array($column, $this->nullable);
	}

	/**
	 * Set column as nullable
	 *
	 * @param string    $column
	 * @param bool|true $flag
	 *
	 * @return $this
	 * @access public
	 */
	public function setNullable($column, $flag = true)
	{
		if ($flag) {
			$this->nullable[] = $column;
			$this->nullable   = array_unique($this->nullable);
		} else {
			$this->nullable = array_diff($this->nullable, [$column]);
		}

		return $this;
	}

}