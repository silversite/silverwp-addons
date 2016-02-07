<?php
namespace SilverZF2\Db\Hydrator\Strategy;
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
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 *
 *
 *
 * @category    Zend Framework 2
 * @package     SilverZF2\Db
 * @subpackage  Hydrator\Strategy
 * @author      Michal Kalkowski <michal.kalkowski at autentika.pl>
 * @copyright   SilverSite.pl (c) 2015
 * @version     1.0
 */
class NumberFormatStrategy implements StrategyInterface
{
	/**
	 * @var array [int $decimals = 4 , string $dec_point, string $thousands_sep]
	 */
	private $format = [4, ',', ''];

	/**
	 * CurrencyFormatStrategy constructor.
	 *
	 * @param array $format
	 */
	public function __construct(array $format = [4, ',', ''])
	{
		$this->format = $format;
	}

	/**
	 * Converts the given value so that it can be extracted by the hydrator.
	 *
	 * @param float  $value  The original value.
	 *
	 * @return string Returns the value that should be extracted.
	 */
	public function extract($value)
	{
		if (is_float($value) || is_int($value)) {
			return call_user_func_array('number_format', $this->format);
		}
	}

	/**
	 * Converts the given value so that it can be hydrated by the hydrator.
	 *
	 * @param string $value The original value.
	 *
	 * @return float Returns the value that should be hydrated.
	 */
	public function hydrate($value)
	{
		return $this->toFloat($value);
	}

	/**
	 * @param string $number
	 *
	 * @return float
	 * @access public
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