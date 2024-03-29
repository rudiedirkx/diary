<?php

namespace rdx\diary;

use Symfony\Component\ExpressionLanguage\SyntaxError;

class Property extends Model {

	static public $_table = 'properties';
	static public $types = [];

	static protected array $_all;
	static protected array $_enabled;

	static public function getAll() : array {
		return self::$_all ??= Property::all("1=1 ORDER BY o, id");
	}

	static public function getEnabled() : array {
		return self::$_enabled ??= Property::all("enabled = '1' ORDER BY o, id");
	}

	static public function groupByUI( array $properties ) : array {
		$pid = self::foldAfterId($properties);
		if (!$pid) return [$properties];

		$groups = [[], []];
		$gi = 0;
		foreach ($properties as $property) {
			$groups[$gi][] = $property;

			if ($pid == $property->id) {
				$gi = 1;
			}
		}

		return array_filter($groups);
	}

	static protected function foldAfterId( array $properties ) : ?int {
		$folders = false;
		foreach ( array_reverse($properties) as $property ) {
			if ( $property->canFold() ) {
				$folders = true;
			}
			else {
				return $folders ? $property->id : null;
			}
		}
		return null;
	}

	public function canFold() : bool {
		return self::$types[$this->type]->canFold();
	}

	static public function whereFromFilter( array $properties, array $filters ) : string {
		if ( !count(array_filter($filters)) ) return '1=1';

		$wheres = [];

		if ( ($search = trim($filters['search'] ?? '')) != '' ) {
			$like = '%' . $search . '%';
			$wheres[] = self::$_db->replaceholders("(text LIKE ? OR id IN (select entry_id from entries_properties where value LIKE ?))", [$like, $like]);
		}

		foreach ( $properties as $property ) {
			if ( in_array($property->id, $filters['with'] ?? []) ) {
				$wheres[] = self::$_db->replaceholders('id IN (select entry_id from entries_properties where property_id = ?)', [$property->id]);
			}
		}

		return implode(' AND ', $wheres) ?: '1=1';
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

	public function displayValue( ?string $value, EntryValues $values) {
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

	public function update( $data ) {
		if ( ($data['machine_name'] ?? '--') === '' ) {
			$data['machine_name'] = null;
		}

		return parent::update($data);
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
