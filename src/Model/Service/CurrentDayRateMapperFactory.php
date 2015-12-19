<?php
namespace Currency\Model\Service;

use Currency\Model\Mapper\CurrentDayRate;
use Currency\Model\Entity;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Hydrator;

/**
 *
 * Model table factory class
 *
 * @category   Zend Framework 2
 * @package    Currency
 * @subpackage Model\Service
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl (c) 2015
 * @version    0.1
 */
class CurrentDayRateMapperFactory implements FactoryInterface
{

	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
    {
	    $dbAdapter = $serviceLocator->get('DbAdapter');
	    $entityClass = 'Currency\Model\Entity\CurrentDayRate';

	    $mapper = new CurrentDayRate($dbAdapter, $entityClass);
        return $mapper;
    }
}
