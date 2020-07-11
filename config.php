<?php

use rdx\diary\Property;

require 'inc.bootstrap.php';

$properties = Property::all("1 ORDER BY o, id");
$propertyTypes = array_map(function($type) {
	return $type->label;
}, Property::$types);

if ( isset($_POST['props']) ) {
	foreach ($_POST['props'] as $id => $data) {
		if ( isset($properties[$id]) ) {
			$properties[$id]->save($data + ['enabled' => 0]);
		}
		elseif ( $id == 0 && ($data['name'] ?? '') !== '' ) {
			Property::insert($data);
		}
	}

	return do_redirect(null);
}

include 'tpl.header.php';

?>

<p>
	<a href="index.php">Home</a>
	<a href="queries.php">Queries</a>
</p>

<form method="post" action>
	<table border="1">
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th>Machine name</th>
			<th>Name</th>
			<th>Type</th>
			<th>Display</th>
		</tr>
		<? foreach (array_merge($properties, [new Property(['id' => 0, 'enabled' => 1])]) as $prop): ?>
			<tr>
				<td><?= $prop->id ?: '' ?></td>
				<td>
					<input name="props[<?= $prop->id ?>][enabled]" type="checkbox" value="1" <?= $prop->enabled ? 'checked' : '' ?> class="auto-width" />
				</td>
				<td>
					<input name="props[<?= $prop->id ?>][o]" value="<?= html($prop->o) ?>" type="number" class="int" />
				</td>
				<td>
					<input name="props[<?= $prop->id ?>][machine_name]" value="<?= html($prop->machine_name) ?>" />
				</td>
				<td>
					<input name="props[<?= $prop->id ?>][name]" value="<?= html($prop->name) ?>" />
				</td>
				<td>
					<select name="props[<?= $prop->id ?>][type]"><?= html_options($propertyTypes, $prop->type) ?></select>
				</td>
				<td style="width: 20em">
					<input name="props[<?= $prop->id ?>][display]" value="<?= html($prop->display) ?>" />
				</td>
			</tr>
		<? endforeach ?>
	</table>
	<p><button>Save</button></p>
</form>

<?php

include 'tpl.footer.php';
