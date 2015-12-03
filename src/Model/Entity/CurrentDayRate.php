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

/**
 *
 *
 *
 * @category  Zend Framework 2
 * @package
 * @author    Michal Kalkowski <michal at silversite.pl>
 * @copyright SilverSite.pl 2015
 * @version   $Revision:$
 */
class CurrentDayRate implements CurrentDayRateInterface
{
	/**
	 * @var int
	 */
	protected $currentDayRateId;

	/**
	 * @var int
	 */
	protected $currencyId;

	/**
	 * @var int
	 */
	protected $currencyCounter;

	/**
	 * @var float
	 */
	protected $currencyRate;

	/**
	 * @var float
	 */
	protected $currencyChangeRate;

	/**
	 * @return int
	 */
	public function getCurrentDayRateId() {
		return $this->currentDayRateId;
	}

	/**
	 * @param int $currentDayRateId
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrentDayRateId( $currentDayRateId ) {
		$this->currentDayRateId = $currentDayRateId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrencyId() {
		return $this->currencyId;
	}

	/**
	 * @param int $currencyId
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyId( $currencyId ) {
		$this->currencyId = $currencyId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrencyCounter() {
		return $this->currencyCounter;
	}

	/**
	 * @param int $currencyCounter
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyCounter( $currencyCounter ) {
		$this->currencyCounter = $currencyCounter;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getCurrencyRate() {
		return $this->currencyRate;
	}

	/**
	 * @param float $currencyRate
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyRate( $currencyRate ) {
		$this->currencyRate = $currencyRate;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getCurrencyChangeRate() {
		return $this->currencyChangeRate;
	}

	/**
	 * @param float $currencyChangeRate
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyChangeRate( $currencyChangeRate ) {
		$this->currencyChangeRate = $currencyChangeRate;

		return $this;
	}
}