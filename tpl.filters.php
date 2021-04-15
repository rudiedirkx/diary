<details <? if ($showHomeLink): ?>open<? endif ?>>
	<summary>Filters</summary>
	<form method="get" action="" class="filter">
		<? foreach ($properties as $property): ?>
			<label>
				<input type="checkbox" name="with[]" value="<?= $property->id ?>" <?= in_array($property->id, $_GET['with'] ?? []) ? 'checked' : '' ?> />
				With <em><?= html($property) ?></em>
			</label>
		<? endforeach ?>
		<input type="search" name="search" placeholder="Search all" size="10" value="<?= html($_GET['search'] ?? '') ?>" />
		<input type="date" name="date" value="<?= html($_GET['date'] ?? '') ?>" />
		<button>Filter</button>
	</form>
</details>
