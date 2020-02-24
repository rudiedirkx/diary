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

$entries = Entry::all('1 ORDER BY date DESC LIMIT 366');
$props = Entry::eager('properties', $entries);
EntryProperty::eager('property', $props);

$entry = Entry::find($_GET['edit'] ?? 0);
if (!$entry && reset($entries)->date == date('Y-m-d', strtotime('-4 hours'))) {
	$entry = reset($entries);
}

include 'tpl.header.php';

$properties = Property::all("enabled = '1' ORDER BY o, id");

?>

<? include 'tpl.form.php'; ?>

<p><a href="config.php">Config</a></p>

<? foreach ($entries as $entry): ?>
	<h2><a href="?edit=<?= $entry->id ?>"><?= $entry->date ?></a></h2>
	<p><?= nl2br(html($entry->text)) ?></p>
	<table>
		<? foreach ($entry->property_displays as $display): ?>
			<tr>
				<th><?= html($display->property) ?></th>
				<td><?= html($display->value) ?></td>
			</tr>
		<? endforeach ?>
	</table>
<? endforeach ?>

<?php

include 'tpl.footer.php';
