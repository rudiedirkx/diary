<form method="post" action="">
	<fieldset>
		<p>Date: <input type="date" /></p>
		<p><textarea></textarea></p>
		<table border="1">
			<? foreach ($properties as $prop): ?>
				<tr>
					<th><?= html($prop) ?></th>
					<td><?= $prop->makeFormHtml() ?></td>
				</tr>
			<? endforeach ?>
		</table>
		<p><button>Save</button></p>
	</fieldset>
</form>
