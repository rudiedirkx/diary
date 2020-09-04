<?php

use rdx\diary\Entry;
use rdx\diary\EntryProperty;
use rdx\diary\Property;
use rdx\diary\Query;

require 'inc.bootstrap.php';

if ( isset($_POST['date'], $_POST['text']) ) {
	$props = $_POST['props'] ?? [];
	unset($_POST['props']);

	$db->begin();

	if ( !empty($_POST['id']) ) {
		$new = false;
		$entry = Entry::find($_POST['id']);
		unset($_POST['id']);
		$_POST['text'] = trim($_POST['text']);
		$entry->update($_POST);
	}
	else {
		$new = true;
		unset($_POST['id']);
		$entry = Entry::find(Entry::insert($_POST));
	}

	$saved = $entry->saveProps($props);
	if ( !$saved ) {
		if ( $new ) {
			$entry->delete();
		}

		header('HTTP/1.0 400 Property save failed');
		exit("Property save failed. Go back?\n");
	}

	$db->commit();

	setcookie('edited', 1);

	return empty($_GET['ajax']) ? do_redirect(null) : do_json(['ok' => 1]);
}

$edited = !empty($_COOKIE['edited']);
setcookie('edited', 0, 1);

$properties = Property::all("enabled = '1' ORDER BY o, id");

$where = Property::whereFromFilter($properties, $_GET);
$entries = Entry::all("$where ORDER BY date DESC LIMIT 63");
$props = Entry::eager('properties', $entries);
EntryProperty::eager('property', $props);

include 'tpl.header.php';

$queries = Query::all('1 ORDER BY name');

$todayish = date('Y-m-d', strtotime(TODAYISH));

$explicitEntry = $entry = Entry::find($_GET['edit'] ?? 0);
if ( !$entry && count($entries) && reset($entries)->date == $todayish ) {
	$entry = reset($entries);
}

$showForm = $where === '1';
$showHomeLink = $where !== '1';
$showFiltersOpen = $where !== '1';

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
	<div class="entry">
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
