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

use SilverWp\Debug;

/**
 *
 *
 * @property int    $currency_id
 * @property int    $currency_counter
 * @property float  $currency_rate
 * @property float  $currency_change_rate
 * @property string $post_title - currency is (short name like: EUR etc.)
 *
 * @category     Zend Framework 2
 * @package      Currency
 * @subpackage   Entity
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2016
 * @version      0.1
 */
trait RateTrait
{
	use RateFormatTrait;

	/**
	 * @return float
	 * @access public
	 */
	public function getCurrencyRate()
	{
		$rate = $this->currency_rate;

        return $rate;
	}

	/**
	 * @param float $rate
	 *
	 * @return $this
	 * @access public
	 */
	public function setCurrencyRate($rate)
	{
		$this->currency_rate = $rate;

		return $this;
	}


}