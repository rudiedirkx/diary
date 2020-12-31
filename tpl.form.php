<form method="post" action="index.php" class="entry <?= $edited ? 'edited' : '' ?>" onsubmit="return fetch(new Request('?ajax=1', {
	method: 'post',
	body: new FormData(this),
})).then(rsp => {
	rsp.clone().json().then(dt => location.reload(), ex => rsp.text().then(txt => alert(txt)))
}), false" oninput="this.classList.add('editing')">
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

<script>
setTimeout(function() {
	const $form = document.querySelector('form.entry.edited');
	$form && $form.classList.remove('edited');
}, 5e3);

setTimeout(function() {
	var T = 0;
	document.querySelector('form').addEventListener('focus', function(e) {
		clearTimeout(T);
		if (e.target.matches('input[type="number"]')) {
			T = setTimeout(() => e.target.select(), 100);
		}
	}, true);
});
</script>
