<?php

use rdx\diary\Entry;
use rdx\diary\EntryProperty;
use rdx\diary\Property;

require 'inc.bootstrap.php';

if ( isset($_POST['date'], $_POST['text']) ) {
	$props = $_POST['props'] ?? [];
	unset($_POST['props']);

	if ( !empty($_POST['id']) ) {
		$new = false;
		$entry = Entry::find($_POST['id']);
		unset($_POST['id']);
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

		exit("Property save failed. Go back?\n");
	}

	return do_redirect(null);
}

$properties = Property::all("enabled = '1' ORDER BY o, id");

$where = Property::whereFromFilter($properties, $_GET);
$entries = Entry::all("$where ORDER BY date DESC LIMIT 366");
$props = Entry::eager('properties', $entries);
EntryProperty::eager('property', $props);

include 'tpl.header.php';

$todayish = date('Y-m-d', strtotime('-5 hours'));

$explicitEntry = $entry = Entry::find($_GET['edit'] ?? 0);
if ( !$entry && reset($entries)->date == $todayish ) {
	$entry = reset($entries);
}

if ( $where === '1' ) {
	include 'tpl.form.php';
}

?>

<p>
	<? if ($where !== '1'): ?><a href="index.php">Home</a><? endif ?>
	<a href="config.php">Config</a>
</p>

<? include 'tpl.filters.php'; ?>

<? $prevDate = null ?>
<? foreach ($entries as $entry):
	$days = $prevDate ? get_days_diff($prevDate, $entry->date) - 1 : null;
	$prevDate = $entry->date;
	?>
	<? if ($days): ?>
		<div class="between-entries">...<?= $days ?> days...</div>
	<? endif ?>
	<div class="entry">
		<h2><a href="?edit=<?= $entry->id ?>"><?= $entry->pretty_date ?></a></h2>
		<p><?= nl2br(html($entry->text)) ?></p>
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
