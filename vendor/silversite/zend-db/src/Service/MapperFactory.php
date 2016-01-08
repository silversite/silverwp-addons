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

namespace SilverZF2\Db\Service;

use SilverWp\Debug;
use SilverZF2\Db\Entity\Entity;
use SilverZF2\Db\Mapper\AbstractDbMapper;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 *
 * Model table factory class not implemented yet
 *
 * @category   Zend Framework 2
 * @package    Currency
 * @subpackage Model\Service
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl (c) 2015
 * @version    0.1
 */
class MapperFactory implements AbstractFactoryInterface
{

	/**
	 * Determine if we can create a service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param string                  $name
	 * @param string                  $requestedName
	 *
	 * @return bool
	 */
	public function canCreateServiceWithName(
		ServiceLocatorInterface $serviceLocator, $name, $requestedName
	) {
		return preg_match('#^Mapper\\\\(.+)$#', $requestedName);
	}

	/**
	 * Create service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param                         $name
	 * @param                         $requestedName
	 *
	 * @return mixed
	 * @throws \LogicException
	 */
	public function createServiceWithName(
		ServiceLocatorInterface $serviceLocator, $name, $requestedName
	) {
		if ( ! preg_match('#^Mapper\\\\(.+)$#', $requestedName, $match)) {
			throw new \LogicException();
		}

		$modelName = $match[1];
		$config    = $serviceLocator->get( 'Config' );
		if (isset($config['db']) && isset($config['db']['models'])) {
			if (isset($config['db']['models'][$modelName])) {
				$modelConfig  = $config['db']['models'][$modelName];

				if (array_key_exists('mapper', $modelConfig)) {
					$dbAdapter   = $serviceLocator->get('DbAdapter');

					if (isset($modelConfig['entity'])) {
						$entityClass = $modelConfig['entity'];
						if ( ! class_exists($entityClass)) {
							throw new \LogicException(
								sprintf('Entity class %s does not exists', $entityClass)
							);
						}

						if ( ! is_subclass_of($entityClass, 'SilverZF2\Db\Entity\Entity')) {
							throw new \LogicException(
								sprintf('Mapper class "%s" is invalid. Expected a subclass of SilverZF2\Db\Entity\Entity', $entityClass)
							);
						}
					} else {
						$entityClass = 'SilverZF2\Db\Entity\Entity';
					}

					$mapperClass = $modelConfig['mapper'];

					if ( ! class_exists($mapperClass)) {
						throw new \LogicException(
							sprintf('Mapper class %s does not exists', $mapperClass)
						);
					}

					if ( ! is_subclass_of($mapperClass, 'SilverZF2\Db\Mapper\AbstractDbMapper')) {
						throw new \LogicException(
							sprintf('Mapper class "%s" is invalid. Expected a subclass of SilverZF2\Db\Mapper\AbstractDbMapper', $mapperClass)
						);
					}

					/** @var $mapper AbstractDbMapper */
					$mapper = new $mapperClass($dbAdapter, $entityClass);
					if (isset($modelConfig['table'])) {
						$mapper->setTableName($modelConfig['table']);
					}
					//add hydrator strategy
					if (isset($modelConfig['strategy'])) {
						$hydrator = $mapper->getHydrator();
						foreach ($modelConfig['strategy'] as $column => $strategyClass) {
							$hydrator->addStrategy($column, new $strategyClass());
						}
					}
 					return $mapper;
				} else {
					throw new \LogicException(
						'No mapper key configuration found!'
					);
				}
			} else {
				throw new \LogicException(
					sprintf('No model configuration found for %s!', $modelName)
				);
			}
		}

		return null;
	}
}