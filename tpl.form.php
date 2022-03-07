<form method="post" action="index.php" class="entry" onsubmit="return this.classList.add('saving'), fetch(new Request('?ajax=1', {
	method: 'post',
	body: new FormData(this),
})).then(rsp => {
	rsp.clone().json().then(dt => this.className = 'entry edited', ex => rsp.text().then(txt => alert(txt)))
}), false" oninput="this.classList.add('editing')">
	<input type="hidden" name="id" value="<?= $_entry->id ?? '' ?>" />

	<fieldset>
		<legend><?= ($_entry ?? null) ? "Edit $_entry->pretty_date" : 'Create' ?></legend>

		<!-- <div><span style="border: dotted 2px #000; display: inline-block; padding: 0 2px; min-width: 0.75em" contenteditable inputmode="numeric">4</span> pannenkoeken, </div> -->

		<? if (!$_explicitEntry && ($_entry ?? null)): ?>
			<input type="hidden" name="date" value="<?= $_entry->date ?>" />
		<? else: ?>
			<p><input type="date" name="date" value="<?= $_entry->date ?? $todayish ?>" /></p>
		<? endif ?>
		<p><textarea name="text" rows="1"><?= html($_entry->text ?? '') ?></textarea></p>
		<table cellpadding="3" cellspacing="0" border="1">
			<? foreach ($groupedProperties as $gi => $group): ?>
				<tbody <? if ($gi == 1): ?>id="folded-properties" hidden<? endif ?>>
					<? foreach ($group as $pi => $prop): ?>
						<tr>
							<th><?= html($prop) ?></th>
							<td><?= $prop->makeFormHtml($_entry->property_values[$prop->id] ?? null) ?></td>
						</tr>
						<? if ($gi == 0 && $pi + 1 == count($group) && isset($groupedProperties[1])): ?>
							<tr>
								<th colspan="2" class="unfold-properties">
									<button type="button">
										<? foreach ($groupedProperties[1] as $prop1): ?>
											<span class="<?= $_entry && $_entry->hasProperty($prop1->id) ? 'with' : 'without' ?>"><?= $prop1 ?></span>,
										<? endforeach ?>
									</button>
								</th>
							</tr>
						<? endif ?>
					<? endforeach ?>
				</tbody>
			<? endforeach ?>
		</table>
		<p><button>Save</button></p>
	</fieldset>
</form>

<script>
setTimeout(function() {
	const $form = document.querySelector('form.entry.edited');
	$form && $form.classList.remove('edited');
}, 5000);

setTimeout(function() {
	var T = 0;
	document.querySelector('form').addEventListener('focus', function(e) {
		clearTimeout(T);
		if (e.target.matches('input[type="number"], [inputmode="numeric"]')) {
			T = setTimeout(() => {
				try {
					e.target.select();
				}
				catch (ex) {
					const r = document.createRange();
					r.setStart(e.target, 0);
					r.setEnd(e.target, 1);
					const s = document.getSelection();
					s.removeAllRanges();
					s.addRange(r);
				}
			}, 100);
		}
	}, true);
});

setTimeout(function() {
	const btn = document.querySelector('.unfold-properties button');
	btn.addEventListener('click', e => {
		e.preventDefault();
		const tb = document.querySelector('#folded-properties');
		tb.hidden = !tb.hidden;
	});
});
</script>
