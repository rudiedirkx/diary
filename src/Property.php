<?php

namespace rdx\diary;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;
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

	public function saveProp( Entry $entry, $value ) {
		if ($this->type == 'bool' && $value) {
			$value = '1';
		}

		EntryProperty::insert([
			'entry_id' => $entry->id,
			'property_id' => $this->id,
			'value' => $value,
		]);
	}

	public function makeFormHtml( $value = null ) {
		if ( isset(self::$types[$this->type]['input_type']) ) {
			$checked = $this->type == 'bool' && $value ? 'checked' : '';
			$value = $this->type != 'bool' && $value !== null ? 'value="' . html($value) . '"' : '';
			return '<input type="' . self::$types[$this->type]['input_type'] . '" name="props[' . $this->id . ']" ' . $checked . ' ' . $value . ' />';
		}

		return '';
	}

	public function displayValue($value, EntryValues $values) {
		if (!$this->display) {
			return $value;
		}

		try {
			$language = new ExpressionLanguage();
			$display = $language->evaluate($this->display, ['value' => $value, 'values' => $values]);
			return $display;
		}
		catch ( SyntaxError $ex ) {
			return 'ERROR: ' . $ex->getMessage();
		}

		return $value;
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
