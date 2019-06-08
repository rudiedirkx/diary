<?php

namespace rdx\diary;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use db_generic_model;

class Property extends db_generic_model {

	static public $_table = 'properties';

	static public $types = [
		'text' => [
			'label' => 'Text',
			'input_type' => 'text',
		],
		'time' => [
			'label' => 'Time',
			'input_type' => 'time',
		],
		'int' => [
			'label' => 'Integer',
			'input_type' => 'number',
		],
		'bool' => [
			'label' => 'Boolean',
			'input_type' => 'checkbox',
		],
	];

	public function makeFormHtml() {
		if ( isset(self::$types[$this->type]['input_type']) ) {
			return '<input type="' . self::$types[$this->type]['input_type'] . '" name="props[' . $this->id . ']" />';
		}

		return '';
	}

	public function displayValue($value) {
		if (!$this->display) {
			return $value;
		}

		$language = new ExpressionLanguage();
		$display = $language->evaluate($this->display, ['value' => $value]);
		return $display;
	}

	public function save( array $data ) {
		if ( @$data['name'] === '' ) {
			return $this->update(['enabled' => 0]);
		}

		return $this->update($data);
	}

	public function __toString() {
		return $this->name;
	}

}
