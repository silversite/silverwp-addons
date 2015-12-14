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
 * Currency Current day rates entity class
 *
 * @property $currentDayRateId
 * @property $currencyChangeRate
 * @property $currencyCounter
 * @property $currencyRate
 * @property $currencyId
 * @property $postTitle
 *
 * @category   Currency
 * @package    Model
 * @subpackage Entity
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
class CurrentDayRate extends Entity
{
	/**
	 * @return float
	 */
	public function getCurrencyChangeRate()
	{
		return $this->currencyChangeRate;
	}

	/**
	 * @param float $changeRate
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyChangeRate($changeRate)
	{
		$this->currencyChangeRate = $changeRate;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrentDayRateId()
	{
		return $this->currentDayRateId;
	}

	/**
	 * @param int $currentDayRateId
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrentDayRateId($currentDayRateId)
	{
		$this->currentDayRateId = $currentDayRateId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrencyId()
	{
		return $this->currencyId;
	}

	/**
	 * @param int $currencyId
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyId($currencyId)
	{
		$this->currencyId = $currencyId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrencyCounter()
	{
		return $this->currencyCounter;
	}

	/**
	 * @param int $counter
	 *
	 * @return $this
	 */
	public function setCurrencyCounter($counter)
	{
		$this->currencyCounter = $counter;

		return $this;
	}
	/**
	 * @return float
	 */
	public function getCurrencyRate()
	{
		return $this->currencyRate;
	}

	/**
	 * @param float $rate
	 *
	 * @return CurrentDayRate
	 */
	public function setCurrencyRate($rate)
	{
		$this->currencyRate = $rate;

		return $this;
	}

}