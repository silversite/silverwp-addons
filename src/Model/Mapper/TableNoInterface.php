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

namespace Currency\Model\Mapper;


/**
 *
 * Table no interface
 *
 * @category   Zend Framework 2
 * @package    Currency
 * @subpackage Mapper
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl 2016
 * @version    $Revision:$
 */
interface TableNoInterface
{
	/**
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return \Currency\Model\Entity\TableNoInterface
	 * @access public
	 */
	public function getAll($limit, $offset);

	/**
	 * @return \Currency\Model\Entity\TableNoInterface
	 * @access public
	 */
	public function getFirstTableNo();

	/**
	 * @return \Currency\Model\Entity\TableNoInterface
	 * @access public
	 */
	public function getLastTableNo();
}