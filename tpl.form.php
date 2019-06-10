<form method="post" action="index.php">
	<input type="hidden" name="id" value="<?= $entry->id ?? '' ?>" />

	<fieldset>
		<legend><?= ($entry ?? null) ? "Edit $entry->date" : 'Create' ?></legend>

		<p>Date:<br><input type="date" name="date" value="<?= $entry->date ?? date('Y-m-d') ?>" /></p>
		<p><textarea name="text" cols="50" rows="4"><?= html($entry->text ?? '') ?></textarea></p>
		<table border="1">
			<? foreach ($properties as $prop): ?>
				<tr>
					<th><?= html($prop) ?></th>
					<td><?= $prop->makeFormHtml($entry->property_values[$prop->id] ?? null) ?></td>
				</tr>
			<? endforeach ?>
		</table>
		<p><button>Save</button></p>
	</fieldset>
</form>
