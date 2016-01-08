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
 * History entity interface
 *
 * @property \DateTime $currency_date
 *
 * @category   Currency
 * @package    Model
 * @subpackage Entity
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
interface HistoryInterface
{
	/**
	 * @return int
	 * @access public
	 */
	public function getCurrencyDate();

	/**
	 * @param \DateTime $date
	 *
	 * @return $this
	 * @access public
	 */
	public function setCurrencyDate(\DateTime $date);
}