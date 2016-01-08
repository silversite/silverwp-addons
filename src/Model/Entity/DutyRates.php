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
 * @property \DateTime $current_publication_date
 *
 * @category   Currency
 * @package    Model
 * @subpackage Entity
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
class DutyRates extends Entity implements CurrentRatesInterface, HistoryInterface
{
	use CurrentRatesTrait;
	use HistoryTrait;

	/**
	 * @return \DateTime
	 */
	public function getCurrentPublicationDate()
	{
		return new \DateTime($this->current_publication_date);
	}

	/**
	 * @param \DateTime $current_publication_date
	 *
	 * @return DutyRates
	 */
	public function setCurrentPublicationDate( \DateTime $current_publication_date )
	{
		$this->current_publication_date = $current_publication_date;

		return $this;
	}
}