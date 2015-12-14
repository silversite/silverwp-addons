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
		'prefix'   => DB_PREFIX

	],
	'service_manager' => [
		'factories' => [
			'DbAdapter'      => 'SilverZF2\Db\Adapter\AdapterServiceFactory',
			'CurrentDayRate' => 'Currency\Model\Service\CurrentDayRateMapperFactory',
			'TableNo'        => 'Currency\Model\Service\CurrentDayTableNoMapperFactory',
		],

	],
];

return $config;
