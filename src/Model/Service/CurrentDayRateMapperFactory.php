<?php
namespace Currency\Model\Service;

use Currency\Model\Mapper\CurrentDayRate;
use Currency\Model\Entity;
use SilverWp\Debug;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Hydrator;

class CurrentDayRateMapperFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $services)
    {
	    $dbAdapter = $services->get('DbAdapter');
	    $entityClass = new Entity\CurrentDayRate();

	    $mapper = new CurrentDayRate($dbAdapter, $entityClass);
        return $mapper;
    }
}
