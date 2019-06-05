<?php

use rdx\diary\Property;

require 'inc.bootstrap.php';

$properties = Property::all('1');
$propertyTypes = ['text', 'int', 'bool'];
$propTypeOptions = array_combine($propertyTypes, $propertyTypes);

if ( isset($_POST['props']) ) {
	foreach ($_POST['props'] as $id => $data) {
		$properties[$id]->update($data);
	}

	return do_redirect(null);
}

include 'tpl.header.php';

?>

<form method="post" action>
	<table border="1">
		<tr>
			<th>Name</th>
			<th>Type</th>
			<th>Display</th>
		</tr>
		<? foreach ($properties as $prop): ?>
			<tr>
				<td>
					<input name="props[<?= $prop->id ?>][name]" value="<?= html($prop->name) ?>" />
				</td>
				<td>
					<select name="props[<?= $prop->id ?>][type]"><?= html_options($propTypeOptions, $prop->type) ?></select>
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
