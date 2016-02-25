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

use SilverZF2\Db\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Where;

/**
 *
 *
 * @property int $currency_duty_id
 * @property int $currency_publication_date
 *
 * @category     Currency
 * @package      Model
 * @subpackage   Mapper
 * @author       Michal Kalkowski <michal at silversite.pl>
 * @copyright    SilverSite.pl 2015
 * @version      0.1
 */
class DutyRates extends AbstractDbMapper implements CurrentRatesInterface, DutyRatesInterface
{
	use CurrentRatesTrait {
		getRates as parentRates;
	}

	use HistoryTrait;

	/**
	 * @var string
	 */
	protected $tableName = 'currency_duty';

	/**
	 * @var string
	 */
	protected $pkColumn = 'currency_duty_id';

	/**
	 * @param bool $mainPageOnly
	 * @param bool $limit
	 *
	 * @param null|string $date - date format Y-m
	 *
	 * @return \Currency\Model\Entity\
	 * @access public
	 */
	public function getRates($mainPageOnly = false, $limit = false, $date = null)
	{
		if (is_null($date)) {
            $dateObj   = new \DateTime();
            $dateStart = $dateObj->format('Y-m') . '-01';
            $dateEnd   = $dateObj->format('Y-m-t');
		} else {
            $dateObj   = new \DateTime($date);
            $dateStart = $dateObj->format('Y-m') . '-01';
            $dateEnd   = $dateObj->format('Y-m-t');
		}

		$where = new Where();
		$where->between('currency_publication_date', $dateStart , $dateEnd);
		$data = $this->parentRates($mainPageOnly, $limit, $where);

        return $data;
	}

	/**
	 * Last publication date
	 *
	 * @return bool|\Currency\Model\Entity\DutyRates
	 * @access public
	 */
	public function getLastPublicationDate()
	{
		$select = $this->getSelect();
		$select
			->columns(['currency_publication_date' => new Expression('MAX(currency_publication_date)')])
			->limit(1)
		;
		$data = $this->select($select);

		return $data->current();
	}

	/**
	 * First publication date
	 *
	 * @return bool|\Currency\Model\Entity\DutyRates
	 * @access public
	 */
	public function getFirstPublicationDate()
	{
		$select = $this->getSelect();
		$select
			->columns(['currency_publication_date' => new Expression('MIN(currency_publication_date)')])
			->limit(1)
		;
        $data = $this->select($select);

		return $data->current();
	}

    public function getFirstYear()
    {
        $select = $this->getSelect();
        $select
            ->columns(
                [
                    'year'  => new Expression('DATE_FORMAT(MAX(currency_date), \'%Y\')'),
                    'month' => new Expression('DATE_FORMAT(MAX(currency_date), \'%m\')')
                ]
            )
            ->limit(1)
        ;
        $data = $this->select($select);

        return $data->current()->toArray();
    }

    /**
     * @param string $month
     * @param string $year
     *
     * @return \Currency\Model\Entity\DutyRates
     *
     * @access   public
     */
	public function getRatesByDate($month, $year)
	{
		$date = new \DateTime($year .'-'. $month);
		$lastDay = $date->format('Y-m-t');

		$where = new Where();
		$where->between('currency_publication_date', $year .'-'. $month . '-01', $lastDay);
		$results = $this->parentRates(false, false, $where);

		return $results;
	}

    /**
     * @param $date
     *
     * @return bool|\SilverZF2\Db\Entity\Entity
     */
    public function getLastRatesByDate($date)
    {
        $select = $this->getSelect();
        $select->where->between('currency_date', $date, new Expression('LAST_DAY(?)', $date));
        $select->order(['currency_date DESC', 'currency_id ASC']);
//        echo $this->getSqlQuery($select);
        $rates  = $this->select($select)->toArray();

        $return = [];
        foreach ($rates as $rate) {
            $return[$rate['currency_id']] = $rate['currency_rate'];
        }
        return $return;
    }
}