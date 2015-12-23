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
 * Currency Entity
 *
 * @property $id
 * @property $post_title
 * @property $post_content
 * @property $post_author
 * @property $post_date
 * @property $post_date_gmt
 * @property $post_excerpt
 * @property $post_status
 * @property $comment_status
 * @property $post_name
 * @property $menu_order
 * @property $guid
 * @property $post_type
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Entity
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      1.0
 */
class Currency extends Entity
{
	/**
	 * @param int $id
	 *
	 * @return $this
	 * @access public
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return int
	 * @access public
	 */
	public function getId()
	{
		return $this->id;
	}
}