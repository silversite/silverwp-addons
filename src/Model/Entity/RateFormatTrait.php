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

use SilverZF2\Db\Entity\Exception\InvalidArgumentException;

/**
 *
 *
 * @category     Zend Framework 2
 * @package      Currency
 * @subpackage   Entity
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2016
 * @version      0.1
 */
trait RateFormatTrait
{
	/**
	 * @var array [int $decimals = 4 , string $dec_point, string $thousands_sep]
	 */
	private $format = [4, '.', ''];

	/**
	 * @return array
	 */
	public function getFormat()
	{
		return $this->format;
	}

	/**
	 * @param array $format
	 *
	 * @return RateFormatTrait
	 */
	public function setFormat( $format )
	{
		$this->format = $format;

		return $this;
	}

	/**
	 * @param float $rate
	 *
	 * @return float
	 * @access protected
	 * @throws \SilverZF2\Db\Entity\Exception\InvalidArgumentException
	 */
	public function toString($rate)
	{
		if ( ! is_float($rate)) {
			throw new InvalidArgumentException(
				vsprintf('The given value is invalid. Expected float, %s given.', [gettype($rate)])
			);
		}
		$params = array_merge([$rate], $this->format);

		return call_user_func_array('number_format', $params);
	}

	/**
	 * @param string $number
	 *
	 * @return float
	 * @access protected
	 */
	public function toFloat($number)
	{
		$dotPos     = strrpos($number, '.');
		$commaPos   = strrpos($number, ',');
		if (($dotPos > $commaPos) && $dotPos) {
			$separator = $dotPos;
		} else {
			if (($commaPos > $dotPos) && $commaPos) {
				$separator = $commaPos;
			} else {
				$separator = false;
			}
		}

		if ( ! $separator) {
			return floatval(preg_replace('/[^0-9]/', '', $number));
		}

		return floatval(
			preg_replace('/[^0-9]/', '', substr($number, 0, $separator)) . '.' .
			preg_replace('/[^0-9]/', '', substr($number, $separator + 1, strlen($number)))
		);
	}
}