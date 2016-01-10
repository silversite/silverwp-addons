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
			'AverageCurrentRates' => [
				'table'  => 'current_day_rate',
				'entity' => 'Currency\Model\Entity\AverageCurrentRates',
				'mapper' => 'Currency\Model\Mapper\AverageCurrentRates',
				'strategy' => [
					'currency_date' => 'Zend\Hydrator\Strategy\DateTimeFormatterStrategy'
				]
			],
			'AverageHistoryRates' => [
				'table'  => 'history_current_day_rate',
				'entity' => 'Currency\Model\Entity\AverageHistoryRates',
				'mapper' => 'Currency\Model\Mapper\AverageHistoryRates',
				'strategy' => [
					'currency_date' => 'Zend\Hydrator\Strategy\DateTimeFormatterStrategy'
				]
			],
			'AverageTableNo' => [
				'table'  => 'current_day_table_no',
				'entity' => 'Currency\Model\Entity\AverageTableNo',
				'mapper' => 'Currency\Model\Mapper\AverageTableNo',
				'strategy' => [
					'table_date' => 'Zend\Hydrator\Strategy\DateTimeFormatterStrategy'
				]
			],
			'SellBuyCurrentRates' => [
				'table'  => 'currency_sell_buy',
				'entity' => 'Currency\Model\Entity\SellBuyCurrentRates',
				'mapper' => 'Currency\Model\Mapper\SellBuyCurrentRates',
			],
			'SellBuyHistoryRates' => [
				'table'  => 'history_currency_sell_buy',
				'entity' => 'Currency\Model\Entity\SellBuyHistoryRates',
				'mapper' => 'Currency\Model\Mapper\SellBuyHistoryRates',
			],
			'SellBuyTableNo' => [
				'table'  => 'sell_buy_table_no',
				'entity' => 'Currency\Model\Entity\SellBuyTableNo',
				'mapper' => 'Currency\Model\Mapper\SellBuyTableNo',
				'strategy' => [
					'table_date' => 'Zend\Hydrator\Strategy\DateTimeFormatterStrategy'
				]
			],
			'IrredeemableCurrentRates' => [
				'table'  => 'currency_irredeemable',
				'entity' => 'Currency\Model\Entity\IrredeemableCurrentRates',
				'mapper' => 'Currency\Model\Mapper\IrredeemableCurrentRates',
			],
			'IrredeemableHistoryRates' => [
				'table'  => 'history_currency_irredeemable',
				'entity' => 'Currency\Model\Entity\IrredeemableHistoryRates',
				'mapper' => 'Currency\Model\Mapper\IrredeemableHistoryRates',
			],
		    'IrredeemableTableNo' => [
			    'table'  => 'irredeemable_table_no',
			    'entity' => 'Currency\Model\Entity\IrredeemableTableNo',
			    'mapper' => 'Currency\Model\Mapper\IrredeemableTableNo',
		        'strategy' => [
			        'table_date' => 'Zend\Hydrator\Strategy\DateTimeFormatterStrategy'
		        ]
		    ],
			'DutyRates' => [
				'table'  => 'currency_duty',
				'entity' => 'Currency\Model\Entity\DutyRates',
				'mapper' => 'Currency\Model\Mapper\DutyRates',
				'strategy' => [
					'currency_date' => 'Zend\Hydrator\Strategy\DateTimeFormatterStrategy',
					'currency_publication_date' => 'Zend\Hydrator\Strategy\DateTimeFormatterStrategy'
				]
			],
		]

	],
	'service_manager' => [
		//abstract factories
		'abstract_factories' => [
//			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',    //cache
			'SilverZF2\Db\Service\MapperFactory' //mapper construct factory loader
		],
		'factories' => [
			'DbAdapter'             => 'SilverZF2\Db\Adapter\AdapterServiceFactory',
			'Currency'              => 'Currency\Model\Service\CurrencyMapperFactory',
		],
	],
];

return $config;
