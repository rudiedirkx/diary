<?php

header('Content-type: text/html; charset=utf-8');

?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8" />
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
	input,
	textarea {
		width: 100%;
	}
	input.auto-width,
	textarea.auto-width {
		width: auto;
	}
	input.int {
		width: 1.5em;
		text-align: center;
	}
	textarea[name="text"]:focus {
		height: 5em;
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
