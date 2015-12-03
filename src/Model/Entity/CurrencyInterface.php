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
 * Currency entity interface
 *
 * @category  Zend Framework 2
 * @package   Currency
 * @author    Michal Kalkowski <michal at silversite.pl>
 * @copyright SilverSite.pl 2015
 * @version   1.0
 */
interface CurrencyInterface extends EntityPrototype
{
	public function getCurrencyId();
	public function setCurrencyId($id);
	public function getCurrencySymbol();
	public function setCurrencySymbol($symbol);
	public function getCurrencyCountry();
	public function setCurrencyCountry($country);
	public function getCurrencyLogo();
	public function setCurrencyLogo($logo);
	public function getCurrencyContinent();
	public function setCurrencyContinent($continentId);
	public function getCurrencyDescription();
	public function setCurrencyDescription($description);
	public function getCurrencyMainPage();
	public function setCurrencyMainPage($mainPage);
	public function getCurrencyOrder();
	public function setCurrencyOrder($order);
}