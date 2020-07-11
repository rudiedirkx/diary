<?php

use rdx\diary\Query;

require 'inc.bootstrap.php';

$queries = Query::all('1 ORDER BY name');

if ( isset($_POST['queries']) ) {
	foreach ($_POST['queries'] as $id => $data) {
		if ( isset($queries[$id]) ) {
			$queries[$id]->update($data);
		}
		elseif ( $id == 0 && ($data['name'] ?? '') !== '' ) {
			Query::insert($data);
		}
	}

	return do_redirect(null);
}

include 'tpl.header.php';

$queries[0] = new Query(['id' => 0]);

?>

<style>
input, textarea {
	width: 100%;
}
input, fieldset {
	margin-bottom: 0.5em;
}
</style>

<p>
	<a href="index.php">Home</a>
	<a href="config.php">Config</a>
</p>

<form method="post" action>
	<? foreach ($queries as $query): ?>
		<fieldset>
			<input name="queries[<?= $query->id ?>][name]" value="<?= html($query->name) ?>" /><br>
			<textarea name="queries[<?= $query->id ?>][query]" rows="5"><?= html($query->query) ?></textarea><br>
			<? if ($query->id): ?>
				<a href="query.php?id=<?= $query->id ?>">Go</a>
			<? endif ?>
		</fieldset>
	<? endforeach ?>

	<p><button>Save</button></p>
</form>

<?php

include 'tpl.footer.php';
