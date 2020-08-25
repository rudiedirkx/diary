<?php

use rdx\diary\Query;

require 'inc.bootstrap.php';

$query = Query::find($_GET['id'] ?? 0);

include 'tpl.header.php';

?>

<style>
pre {
	background-color: #eee;
	padding: 6px;
	white-space: pre-wrap;
}

table {
	border-spacing: 0;
}
td, th {
	padding: 4px 6px;
}
</style>

<p>
	<a href="index.php">Home</a>
</p>

<pre><?= html($query->query) ?></pre>

<?php

$records = $db->fetch($query->sql)->all();

if ( !count($records) ) {
	echo '<p>No results</p>';
	include 'tpl.footer.php';
	exit;
}

?>

<table border="1">
	<thead>
		<tr>
			<th colspan="99">Results (<?= count($records) ?>)</th>
		</tr>
		<tr>
			<? foreach ($records[0] as $name => $x): ?>
				<th><?= html($name) ?></th>
			<? endforeach ?>
		</tr>
	</thead>
	<tbody>
		<? foreach ($records as $record): ?>
			<tr>
				<? foreach ($record as $name => $value): ?>
					<td><?= html($value) ?></td>
				<? endforeach ?>
			</tr>
		<? endforeach ?>
	</tbody>
</table>

<?php

include 'tpl.footer.php';
