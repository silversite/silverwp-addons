<?php
namespace Currency\Model\Service;

use Currency\Model\Entity;
use Currency\Model\Mapper\CurrentDayTableNo;
use SilverZF2\Db\Hydrator\Strategy\DateTimeStrategy;
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
class CurrentDayTableNoMapperFactory implements FactoryInterface
{

	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
    {
	    $dbAdapter   = $serviceLocator->get( 'DbAdapter' );
	    $entityClass = new Entity\CurrentDayTableNo();
	    $mapper      = new CurrentDayTableNo( $dbAdapter, $entityClass );
	    $mapper->getHydrator()
	           ->addStrategy( 'table_date', new DateTimeStrategy() )
	    ;

	    return $mapper;
    }
}
