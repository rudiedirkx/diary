<?php

namespace rdx\diary;

use Symfony\Component\ExpressionLanguage\SyntaxError;

class Property extends Model {

	static public $_table = 'properties';

	static public $types = [];

	static public function whereFromFilter( array $properties, array $filters ) {
		if ( !count(array_filter($filters)) ) return '1';

		$wheres = [];

		if ( trim($filters['search'] ?? '') != '' ) {
			$like = '%' . $filters['search'] . '%';
			$wheres[] = self::$_db->replaceholders("(text LIKE ? OR id IN (select entry_id from entries_properties where value LIKE ?))", [$like, $like]);
		}

		foreach ( $properties as $property ) {
			if ( in_array($property->id, $filters['with'] ?? []) ) {
				$wheres[] = self::$_db->replaceholders('id IN (select entry_id from entries_properties where property_id = ?)', [$property->id]);
			}
		}

		return implode(' AND ', $wheres) ?: '1';
	}

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
			$display = $GLOBALS['expr']->evaluate($this->display, ['value' => $value, 'values' => $values]);
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
