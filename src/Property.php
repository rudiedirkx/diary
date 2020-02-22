<?php

namespace rdx\diary;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;
use db_generic_model;

class Property extends db_generic_model {

	static public $_table = 'properties';

	static public $types = [];

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
		return self::$types[$this->type]->makeFormHtml("props[$this->id]", $value);
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
