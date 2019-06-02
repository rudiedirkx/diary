<?php

use rdx\diary\Entry;
use rdx\diary\EntryProperty;

require 'inc.bootstrap.php';

$entries = Entry::all('1 ORDER BY date DESC LIMIT 10');
$props = Entry::eager('properties', $entries);
EntryProperty::eager('property', $props);

include 'tpl.header.php';

?>

<? foreach ($entries as $entry): ?>
	<h2><?= $entry->date ?></h2>
	<p><?= nl2br(html($entry->text)) ?></p>
	<table>
		<? foreach ($entry->properties as $prop): ?>
			<tr>
				<th><?= html($prop->property) ?></th>
				<td><?= html($prop->value) ?></td>
			</tr>
		<? endforeach ?>
	</table>
<? endforeach ?>

<?php

include 'tpl.footer.php';
