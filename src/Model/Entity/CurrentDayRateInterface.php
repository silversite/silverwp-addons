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

use SilverSite\Db\Entity\EntityPrototype;


/**
 *
 *
 *
 * @category     Zend Framework 2
 * @package      Model
 * @subpackage   Entity
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
interface CurrentDayRateInterface extends EntityPrototype {

	/**
	 * @return int
	 */
	public function getCurrentDayRateId();

	/**
	 * @param int $currentDayRateId
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrentDayRateId( $currentDayRateId );

	/**
	 * @return int
	 */
	public function getCurrencyId();

	/**
	 * @param int $currencyId
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyId( $currencyId );

	/**
	 * @return int
	 */
	public function getCurrencyCounter();

	/**
	 * @param int $currencyCounter
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyCounter( $currencyCounter );

	/**
	 * @return float
	 */
	public function getCurrencyRate();

	/**
	 * @param float $currencyRate
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyRate( $currencyRate );

	/**
	 * @return float
	 */
	public function getCurrencyChangeRate();

	/**
	 * @param float $currencyChangeRate
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyChangeRate( $currencyChangeRate );
}