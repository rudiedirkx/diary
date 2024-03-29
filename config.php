<?php

use rdx\diary\Property;

require 'inc.bootstrap.php';

$properties = Property::getAll();
$propertyTypes = array_map(function($type) {
	return $type->label;
}, Property::$types);

if ( isset($_POST['props']) ) {
	foreach ($_POST['props'] as $id => $data) {
		if ( isset($properties[$id]) ) {
			$properties[$id]->save($data + ['enabled' => 0, 'render_always' => 0]);
		}
		elseif ( $id == 0 && ($data['name'] ?? '') !== '' ) {
			Property::insert($data);
		}
	}

	return do_redirect(null);
}

include 'tpl.header.php';

?>
<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
	-webkit-appearance: none;
	appearance: none;
	margin: 0;
}
input[type=number] {
	-moz-appearance: textfield;
}
</style>

<p>
	<a href="index.php">Home</a>
	<a href="queries.php">Queries</a>
</p>

<form class="config" method="post" action>
	<table border="1">
		<tr>
			<th class="c">ID</th>
			<th class="c">?</th>
			<th class="c">O</th>
			<th>Machine name</th>
			<th>Name</th>
			<th>Type</th>
			<th>Display</th>
			<th class="c">Always</th>
		</tr>
		<? foreach (array_merge($properties, [new Property(['id' => 0, 'enabled' => 1, 'render_always' => 0])]) as $prop): ?>
			<tr>
				<td class="c"><?= $prop->id ?: '' ?></td>
				<td class="c">
					<input name="props[<?= $prop->id ?>][enabled]" type="checkbox" value="1" <?= $prop->enabled ? 'checked' : '' ?> class="auto-width" />
				</td>
				<td class="c">
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
				<td>
					<input name="props[<?= $prop->id ?>][display]" value="<?= html($prop->display) ?>" style="width: 30em" />
				</td>
				<td class="c">
					<input name="props[<?= $prop->id ?>][render_always]" type="checkbox" value="1" <?= $prop->render_always ? 'checked' : '' ?> class="auto-width" />
				</td>
			</tr>
		<? endforeach ?>
	</table>
	<p><button>Save</button></p>
</form>

<?php

include 'tpl.footer.php';
