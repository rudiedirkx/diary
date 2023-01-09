<?php

use rdx\diary\Entry;
use rdx\diary\EntryProperty;
use rdx\diary\Property;
use rdx\diary\Query;

require 'inc.bootstrap.php';

if ( isset($_POST['date'], $_POST['text']) ) {
	$props = $_POST['props'] ?? [];
	unset($_POST['props']);

	$entry = Entry::first(['date' => $_POST['date']]);

	$db->transaction(function() use (&$entry, $props) {
		if ( $entry ) {
			$entry->update($_POST);
		}
		else {
			$entry = Entry::find(Entry::insert($_POST));
		}

		$entry->saveProps($props);
	});

	return empty($_GET['ajax']) ? do_redirect(null) : do_json(['ok' => 1]);
}

$properties = Property::getEnabled();
$groupedProperties = Property::groupByUI($properties);

$where = Property::whereFromFilter($properties, $_GET);
//var_dump($where);
$limit = strlen($where) > 3 ? 20 : 8;
$entries = Entry::all("$where ORDER BY date DESC LIMIT $limit");
$props = Entry::eager('properties', $entries);
EntryProperty::eager('property', $props);

include 'tpl.header.php';

$queries = Query::all("visible = '1' ORDER BY name");

$todayish = date('Y-m-d', strtotime(TODAYISH));

$_explicitEntry = $_entry = Entry::byIdOrDate($_GET['edit'] ?? null, $_GET['date'] ?? null);
if ( !$_entry && count($entries) && reset($entries)->date == $todayish ) {
	$_entry = reset($entries);
}

$showForm = $where === '1=1';
$showHomeLink = $where !== '1=1';
$showFiltersOpen = $where !== '1=1';

if ( $showForm ) {
	include 'tpl.form.php';
}

?>

<p>
	<? if ($showHomeLink): ?><a href="index.php">Home</a><? endif ?>
	<a href="config.php">Config</a>
	<a href="queries.php">Queries</a>
</p>

<details>
	<summary>Queries</summary>
	<ul>
		<? foreach ($queries as $query): ?>
			<li><a href="query.php?id=<?= $query->id ?>"><?= html($query->name) ?></a></li>
		<? endforeach ?>
	</ul>
</details>

<? include 'tpl.filters.php'; ?>

<? $prevDate = date('Y-m-d', strtotime('tomorrow', strtotime(TODAYISH))) ?>
<? foreach ($entries as $entry):
	$days = $prevDate ? get_days_diff($prevDate, $entry->date) - 1 : null;
	$prevDate = $entry->date;
	?>
	<? if ($days): ?>
		<div class="between-entries">...<?= $days ?> days...</div>
	<? endif ?>
	<div class="entry <?= $_entry && $entry->id == $_entry->id ? 'opened' : '' ?>">
		<h2><a href="?edit=<?= $entry->id ?>"><?= $entry->pretty_date ?></a></h2>
		<?if ($entry->text): ?>
			<p><?= nl2br(html($entry->text)) ?></p>
		<? endif ?>
		<table>
			<? foreach ($entry->property_displays as $display): ?>
				<tr>
					<th><?= html($display->property) ?></th>
					<td><?= $display->html_value ?></td>
				</tr>
			<? endforeach ?>
		</table>
	</div>
<? endforeach ?>

<?php

include 'tpl.footer.php';
