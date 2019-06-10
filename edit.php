<?php

use rdx\diary\Entry;
use rdx\diary\Property;

require 'inc.bootstrap.php';

$entry = Entry::find($_GET['id']);

include 'tpl.header.php';

$properties = Property::all("enabled = '1' ORDER BY o, id");

include 'tpl.form.php';

?>
