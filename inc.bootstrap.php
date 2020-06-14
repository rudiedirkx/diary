<?php

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use rdx\diary\Property;
use rdx\diary\properties;

require __DIR__ . '/env.php';
require __DIR__ . '/vendor/autoload.php';

$db = db_sqlite::open(array('database' => DB_FILE));
if ( !$db ) {
	exit('No database connecto...');
}

db_generic_model::$_db = $db;

$db->ensureSchema(require 'inc.db-schema.php');

Property::$types['text'] = new properties\Text();
Property::$types['time'] = new properties\Time();
Property::$types['int'] = new properties\Number(0, 'Integer');
Property::$types['number'] = new properties\Number(2, 'Number');
Property::$types['bool'] = new properties\Boolean();

$GLOBALS['expr'] = new ExpressionLanguage();
$GLOBALS['expr']->addFunction(ExpressionFunction::fromPhp('str_replace'));
$GLOBALS['expr']->addFunction(ExpressionFunction::fromPhp('trim'));

header('Content-type: text/plain; charset=utf-8');
