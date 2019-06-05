<?php

namespace rdx\diary;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use db_generic_model;

class Property extends db_generic_model {

	static public $_table = 'properties';

	public function displayValue($value) {
		if (!$this->display) {
			return $value;
		}

		$language = new ExpressionLanguage();
		$display = $language->evaluate($this->display, ['value' => $value]);
		return $display;
	}

	public function __toString() {
		return $this->name;
	}

}
