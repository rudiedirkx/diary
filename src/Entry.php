<?php

namespace rdx\diary;

use db_generic_model;

class Entry extends db_generic_model {

	static public $_table = 'entries';

	public function saveProps( array $props ) {
		$properties = Property::all("enabled = '1'");

		$save = [];
		foreach ($props as $id => $value) {
			if ( !isset($properties[$id]) ) return false;
			$property = $properties[$id];

			if ( trim($value) !== '' ) {
				$save[$id] = trim($value);
			}
		}

		self::$_db->delete(EntryProperty::$_table, ['entry_id' => $this->id]);
		foreach ($save as $id => $value) {
			$properties[$id]->saveProp($this, $value);
		}

		return true;
	}

	protected function get_property_values() {
		$values = [];
		foreach ($this->properties as $prop) {
			$values[$prop->property_id] = $prop->value;
		}

		return $values;
	}

	protected function relate_properties() {
		return $this->to_many(EntryProperty::class, 'entry_id');
	}

}
