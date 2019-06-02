<?php

return [
	'version' => 1,
	'tables' => [
		'entries' => [
			'id' => ['pk' => true],
			'date' => ['null' => false],
			'text' => ['null' => false],
			'created_on' => ['null' => false, 'default' => 0],
			'updated_on' => ['null' => false, 'default' => 0],
		],
		'properties' => [
			'id' => ['pk' => true],
			'name' => ['null' => false],
			'type' => ['null' => false],
		],
		'entries_properties' => [
			'id' => ['pk' => true],
			'entry_id' => ['null' => false, 'references' => ['entries', 'id', 'cascade']],
			'property_id' => ['null' => false, 'references' => ['properties', 'id', 'cascade']],
			'value' => ['null' => false],
		],
	],
	'data' => [
		'entries' => [
			[
				'date' => '2019-06-01',
				'text' => "Hi there!\n\nWelcome to The Diary 2000!\n\nDid some Groceries today, and watched a Movie.",
				'created_on' => 1559509110,
			],
			[
				'date' => '2019-06-02',
				'text' => "Cycled some. And did some other unquantifiable stuff.",
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
