<?php

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use rdx\diary\Property;
use rdx\diary\properties;

require __DIR__ . '/inc.bootstrap-env.php';
require __DIR__ . '/vendor/autoload.php';

// Heroku
if ( $uri = getenv('DATABASE_URL') ) {
	$uri = preg_replace('#^postgres://#', '', $uri);
	$db = db_pgsql::open(array('uri' => $uri));
}
// Heroku/pgsql test
elseif ( defined('HEROKU_PG_URI') && HEROKU_PG_URI ) {
	$db = db_pgsql::open(array('uri' => HEROKU_PG_URI));
}
// Local
else {
	$db = db_sqlite::open(array('database' => DB_FILE));
}

db_generic_model::$_db = $db;

try {
	$db->ensureSchema(require 'inc.db-schema.php');
}
catch (db_exception $ex) {
	echo '<h2>' . $ex->getMessage() . '</h2>';
	echo '<pre>';
	echo html(print_r($ex, 1));
	exit;
}

Property::$types['text'] = new properties\Text();
Property::$types['time'] = new properties\Time();
Property::$types['int'] = new properties\Number(0, 'Integer');
Property::$types['number'] = new properties\Number(2, 'Number');
Property::$types['bool'] = new properties\Boolean();

$GLOBALS['expr'] = new ExpressionLanguage();
$GLOBALS['expr']->addFunction(ExpressionFunction::fromPhp('str_replace'));
$GLOBALS['expr']->addFunction(ExpressionFunction::fromPhp('trim'));

const TODAYISH = '-5 hours';

ini_set('html_errors', 0);
header('Content-type: text/plain; charset=utf-8');
