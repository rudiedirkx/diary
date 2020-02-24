<details>
	<summary>Filters</summary>
	<form method="get" action="" class="filter">
		<? foreach ($properties as $property): ?>
			<label>
				<input type="checkbox" name="with[]" value="<?= $property->id ?>" <?= in_array($property->id, $_GET['with'] ?? []) ? 'checked' : '' ?> />
				With <em><?= html($property) ?></em>
			</label>
		<? endforeach ?>
		<button>Filter</button>
	</form>
</details>
