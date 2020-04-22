<form method="post" action="index.php" class="entry">
	<input type="hidden" name="id" value="<?= $entry->id ?? '' ?>" />

	<fieldset>
		<legend><?= ($entry ?? null) ? "Edit $entry->pretty_date" : 'Create' ?></legend>

		<? if (!$explicitEntry && ($entry ?? null)): ?>
			<input type="hidden" name="date" value="<?= $entry->date ?>" />
		<? else: ?>
			<p><input type="date" name="date" value="<?= $entry->date ?? $todayish ?>" /></p>
		<? endif ?>
		<p><textarea name="text" rows="1"><?= html($entry->text ?? '') ?></textarea></p>
		<table cellpadding="3" cellspacing="0" border="1">
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
