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
 * @version   1.0
 */
class Currency implements CurrencyInterface {
	/**
	 * @var int
	 */
	protected $ID;

	/**
	 * @var string
	 */
	protected $currencySymbol;

	/**
	 * @var string
	 */
	protected $currencyLogo;

	/**
	 * @var string
	 */
	protected $currencyCountry;

	/**
	 * @var int
	 */
	protected $currencyContinent;

	/**
	 * @var string
	 */
	protected $currencyDescription;

	/**
	 * @var int (0/1)
	 */
	protected $currencyMainPage;

	/**
	 * @var int
	 */
	protected $currencyOrder;

	/**
	 * @return mixed
	 */
	public function getCurrencyId() {
		return $this->currencyId;
	}

	/**
	 * @param int $currencyId
	 *
	 * @return Currency
	 */
	public function setCurrencyId( $currencyId ) {
		$this->currencyId = $currencyId;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCurrencySymbol() {
		return $this->currencySymbol;
	}

	/**
	 * @param string $currencySymbol
	 *
	 * @return Currency
	 */
	public function setCurrencySymbol( $currencySymbol ) {
		$this->currencySymbol = $currencySymbol;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCurrencyLogo() {
		return $this->currencyLogo;
	}

	/**
	 * @param string $currencyLogo
	 *
	 * @return Currency
	 */
	public function setCurrencyLogo( $currencyLogo ) {
		$this->currencyLogo = $currencyLogo;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCurrencyCountry() {
		return $this->currencyCountry;
	}

	/**
	 * @param string $currencyCountry
	 *
	 * @return Currency
	 */
	public function setCurrencyCountry( $currencyCountry ) {
		$this->currencyCountry = $currencyCountry;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrencyContinent() {
		return $this->currencyContinent;
	}

	/**
	 * @param int $currencyContinent
	 *
	 * @return Currency
	 */
	public function setCurrencyContinent( $currencyContinent ) {
		$this->currencyContinent = $currencyContinent;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCurrencyDescription() {
		return $this->currencyDescription;
	}

	/**
	 * @param string $currencyDescription
	 *
	 * @return Currency
	 */
	public function setCurrencyDescription( $currencyDescription ) {
		$this->currencyDescription = $currencyDescription;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrencyMainPage() {
		return $this->currencyMainPage;
	}

	/**
	 * @param int $currencyMainPage
	 *
	 * @return Currency
	 */
	public function setCurrencyMainPage( $currencyMainPage ) {
		$this->currencyMainPage = $currencyMainPage;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCurrencyOrder() {
		return $this->currencyOrder;
	}

	/**
	 * @param int $currencyOrder
	 *
	 * @return Currency
	 */
	public function setCurrencyOrder( $currencyOrder ) {
		$this->currencyOrder = $currencyOrder;

		return $this;
	}

}