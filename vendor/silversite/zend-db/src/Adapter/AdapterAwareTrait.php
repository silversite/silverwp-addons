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

namespace SilverZF2\Db\Adapter;


/**
 *
 * Trait Db Adapter
 *
 * @category   Zend Framework 2
 * @package    Db
 * @subpackage Adapter
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2015
 * @version    0.1
 */
trait AdapterAwareTrait
{
	use \Zend\Db\Adapter\AdapterAwareTrait;

	/**
	 * @return Adapter
	 */
	public function getDbAdapter()
	{
		return $this->adapter;
	}
}