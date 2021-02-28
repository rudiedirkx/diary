<?php

header('Content-type: text/html; charset=utf-8');

?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="theme-color" content="#333" />
	<meta name="referrer" content="no-referrer" />
	<title>The Diary 2000</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<style>
	* {
		box-sizing: border-box;
	}
	body {
		max-width: 700px;
		font-family: sans-serif;
	}
	td, th {
		text-align: left;
		vertical-align: top;
	}
	th {
		white-space: nowrap;
	}
	summary {
		padding: 6px 0;
	}

	form.entry.edited table {
		box-shadow: 0 0 10px lime;
	}
	form.entry.editing table {
		box-shadow: 0 0 10px red;
	}

	form.entry input,
	form.entry textarea {
		width: 100%;
	}
	form.entry input.auto-width,
	form.entry textarea.auto-width,
	form.entry input[type="checkbox"] {
		width: auto;
	}
	form.entry textarea[name="text"]:focus {
		height: 5em;
	}

	.entry h2 a {
		color: darkred;
		text-decoration: none;
	}
	.entry.opened h2 a {
		color: white;
		text-shadow: 0 0 5px darkred;
		background: pink;
	}

	h2,
	.between-entries {
		margin: 1em 0 0.25em;
	}

	input.int {
		width: 1.8em;
		text-align: center;
	}

	form.filter label {
		display: inline-block;
	}
	form.filter label {
		margin-right: .5em;
	}
	</style>
</head>

<body>
