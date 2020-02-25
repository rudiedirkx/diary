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
	}
	td, th {
		text-align: left;
		vertical-align: top;
	}
	th {
		white-space: nowrap;
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

	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		appearance: none;
		margin: 0;
	}
	input[type=number] {
		-moz-appearance: textfield;
	}
	</style>
</head>

<body>
