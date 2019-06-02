<?php

require __DIR__ . '/env.php';
require __DIR__ . '/vendor/autoload.php';

$db = db_sqlite::open(array('database' => DB_FILE));
if ( !$db ) {
	exit('No database connecto...');
}

db_generic_model::$_db = $db;

$db->ensureSchema(require 'inc.db-schema.php');

header('Content-type: text/plain; charset=utf-8');
