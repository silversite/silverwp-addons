<?php
namespace SilverZF2\Db\Adapter;

use Zend\Db\Adapter\AdapterAbstractServiceFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * Factory to create instance of DB adapter
 *
 * @category   Zend Framework2
 * @package    SilverZF2
 * @subpackage Db\Adapter
 * @author     Michal Kalkowski <michal at silversite.pl>
 * @copyright  SilverSite.pl (c) 2015
 * @version    0.1
 */
class AdapterServiceFactory extends AdapterAbstractServiceFactory implements FactoryInterface
{
    /**
     * Create db adapter service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Adapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
	    return new Adapter($config['db']);
    }
}
