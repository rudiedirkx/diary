<?php

use rdx\diary\Query;

require 'inc.bootstrap.php';

$queries = Query::all('1 ORDER BY name');

if ( isset($_POST['queries']) ) {
	foreach ($_POST['queries'] as $id => $data) {
		if ( isset($queries[$id]) ) {
			$queries[$id]->update(['visible' => !empty($data['visible'])] + $data);
		}
		elseif ( $id == 0 && ($data['name'] ?? '') !== '' ) {
			Query::insert($data);
		}
	}

	return do_redirect(null);
}

include 'tpl.header.php';

$queries[0] = new Query(['id' => 0, 'visible' => 1]);

?>

<style>
input[type="text"], textarea {
	width: 100%;
}
input, fieldset {
	margin-bottom: 0.5em;
}
input.name {
	width: calc(100% - 5.5em);
}
textarea:focus {
	height: 14em;
}
</style>

<p>
	<a href="index.php">Home</a>
	<a href="config.php">Config</a>
</p>

<form method="post" action>
	<? foreach ($queries as $query): ?>
		<fieldset>
			<input name="queries[<?= $query->id ?>][visible]" type="checkbox" <? if ($query->visible): ?>checked<? endif ?> />
			<input name="queries[<?= $query->id ?>][name]" type="text" value="<?= html($query->name) ?>" class="name" />
			<? if ($query->id): ?>
				<a href="query.php?id=<?= $query->id ?>">Go</a>
			<? endif ?>
			<br>
			<textarea name="queries[<?= $query->id ?>][query]" rows="3"><?= html($query->query) ?></textarea><br>
		</fieldset>
	<? endforeach ?>

	<p><button>Save</button></p>
</form>

<?php

include 'tpl.footer.php';
