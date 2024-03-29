<?php

return [
	'version' => 14,
	'tables' => [
		'entries' => [
			'columns' => [
				'id' => ['pk' => true],
				'date' => ['null' => false],
				'text' => ['null' => false],
				'created_on' => ['null' => false, 'default' => 0],
				'updated_on' => ['null' => false, 'default' => 0],
			],
			'indexes' => [
				'entries_date' => [
					'unique' => true,
					'columns' => ['date'],
				],
			],
		],
		'properties' => [
			'id' => ['pk' => true],
			'machine_name' => ['null' => true],
			'name' => ['null' => false],
			'type' => ['null' => false],
			'display' => ['null' => true],
			'enabled' => ['type' => 'int', 'default' => 1],
			'render_always' => ['type' => 'int', 'default' => 0],
			'o' => ['type' => 'int', 'default' => 0],
		],
		'entries_properties' => [
			'columns' => [
				'id' => ['pk' => true],
				'entry_id' => ['null' => false, 'references' => ['entries', 'id', 'cascade']],
				'property_id' => ['null' => false, 'references' => ['properties', 'id', 'cascade']],
				'value' => ['null' => false],
			],
			'indexes' => [
				'entries_properties_property_entry' => [
					'unique' => true,
					'columns' => ['property_id', 'entry_id'],
				],
			],
		],
		'queries' => [
			'id' => ['pk' => true],
			'name' => ['null' => false],
			'query' => ['null' => false],
			'visible' => ['type' => 'int', 'default' => 1],
		],
	],
	'data' => [
		'queries' => [
			[
				'name' => 'Days of diary',
				'query' => 'select count(1) days from entries',
			],
		],
		'entries' => [
			[
				'date' => '2019-06-01',
				'text' => "Hi there!\n\nWelcome to The Diary 2000!",
				'created_on' => 1559509110,
			],
			[
				'date' => '2019-06-02',
				'text' => "",
				'created_on' => 1559509110,
			],
		],
		'properties' => [
			[
				'name' => 'Groceries',
				'type' => 'bool',
			],
			[
				'name' => 'Movie',
				'type' => 'text',
			],
			[
				'name' => 'Cycling',
				'type' => 'int',
				'display' => 'value ? value ~ "m" : "no"',
			],
		],
		'entries_properties' => [
			[
				'entry_id' => 1,
				'property_id' => 1,
				'value' => 1,
			],
			[
				'entry_id' => 1,
				'property_id' => 2,
				'value' => 'Dumb And Dumber',
			],
			[
				'entry_id' => 2,
				'property_id' => 3,
				'value' => 120,
			],
		],
	],
];
