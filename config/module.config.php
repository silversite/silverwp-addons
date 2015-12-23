<?php
$config = [
	'db'              => [
		'driver'   => 'pdo_mysql',
		'host'     => DB_HOST,
		//'port'        => 3306,
		//'unix_socket' => '/var/run/mysqld/mysqld.sock',
		'dbname'   => DB_NAME,
		'username' => DB_USER,
		'password' => DB_PASSWORD,
		'charset'  => DB_CHARSET,
		'options'  => [ ],
		'prefix'   => DB_PREFIX,
	    //models
		'models' => [
			'HistoryCurrentDayRate' => [
				'table'  => 'history_current_day_rate',
				'entity' => 'Currency\Model\Entity\HistoryCurrentDayRate',
				'mapper' => 'Currency\Model\Mapper\HistoryCurrentDayRate',
			]
		]

	],
	'service_manager' => [
		//abstrakcyjne fabryki
		'abstract_factories' => [
//			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',    //cache
			'SilverZF2\Db\Service\MapperFactory' //mapper construct factory loader
		],
		'factories' => [
			'DbAdapter'             => 'SilverZF2\Db\Adapter\AdapterServiceFactory',
			'CurrentDayRate'        => 'Currency\Model\Service\CurrentDayRateMapperFactory',
			'TableNo'               => 'Currency\Model\Service\CurrentDayTableNoMapperFactory',
			'Currency'              => 'Currency\Model\Service\CurrencyMapperFactory',
		],
	],
];

return $config;
