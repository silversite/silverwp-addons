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

namespace SilverZF2\Common;
use SilverZF2\Common\Traits\SingletonAwareTrait;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceManager;

/**
 *
 *
 *
 * @category  Zend Framework 2
 * @package   SilverZF2
 * @package   Common
 * @author    Michal Kalkowski <michal at silversite.pl>
 * @copyright SilverSite.pl 2015
 * @version   0.1
 */
class Application
{
	use SingletonAwareTrait;
	use ServiceLocatorAwareTrait;

	protected $config = [];

	public function init(array $config = [])
	{
		$this->config = $config;

		$serviceManagerConfig = isset($this->config['service_manager']) ? $this->config['service_manager'] : [];
		$serviceManager = new ServiceManager(new Config($serviceManagerConfig));
		$serviceManager->setService('Config', $this->config);
		$this->setServiceLocator($serviceManager);
	}

	/**
	 * @param string $newConfigPath
	 * @return array
	 */
	public static function getMergedConfig($newConfigPath = null)
	{
		static $configPath = null;

		if($newConfigPath) {
			$configPath = $newConfigPath;
		}

		$merger = new ConfigMerger($configPath);
		$merger->addRequiredFile('config.php')
		       ->addOptionalFile('config.local.php')
		       ->addOptionalFile('config.generated.php');

		return $merger->getConfig();
	}

	/**
	 * Get service object
	 *
	 * @param string $serviceName
	 *
	 * @return array|object
	 * @static
	 * @access public
	 */
	public static function getService($serviceName)
	{
		$application = self::getInstance();

		$service = $application->getServiceLocator()->get($serviceName);

		return $service;
	}
}