<?php

use rdx\diary\Property;

require 'inc.bootstrap.php';

$properties = Property::all("enabled = '1' ORDER BY o, id");
$propertyTypes = array_map(function($type) {
	return $type['label'];
}, Property::$types);

if ( isset($_POST['props']) ) {
	foreach ($_POST['props'] as $id => $data) {
		if ( isset($properties[$id]) ) {
			$properties[$id]->save($data);
		}
		elseif ( $id == 0 && ($data['name'] ?? '') !== '' ) {
			Property::insert($data);
		}
	}

	return do_redirect(null);
}

include 'tpl.header.php';

?>

<form method="post" action>
	<table border="1">
		<tr>
			<th></th>
			<th>Name</th>
			<th>Type</th>
			<th>Display</th>
		</tr>
		<? foreach (array_merge($properties, [new Property(['id' => 0])]) as $prop): ?>
			<tr>
				<td>
					<input name="props[<?= $prop->id ?>][o]" value="<?= html($prop->o) ?>" type="number" class="int" />
				</td>
				<td>
					<input name="props[<?= $prop->id ?>][name]" value="<?= html($prop->name) ?>" />
				</td>
				<td>
					<select name="props[<?= $prop->id ?>][type]"><?= html_options($propertyTypes, $prop->type) ?></select>
				</td>
				<td>
					<input name="props[<?= $prop->id ?>][display]" value="<?= html($prop->display) ?>" />
				</td>
			</tr>
		<? endforeach ?>
	</table>
	<p><button>Save</button></p>
</form>

<?php

include 'tpl.footer.php';
