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

	protected function get_pretty_date() {
		return date('D d-m-Y', strtotime($this->date));
	}

	protected function get_property_values() {
		$values = [];
		foreach ($this->properties as $prop) {
			$values[$prop->property_id] = $prop->value;
		}

		return $values;
	}

	protected function get_named_property_values() {
		$values = [];
		foreach ($this->properties as $prop) {
			if ( $prop->property->machine_name ) {
				$values[$prop->property->machine_name] = $prop->value;
			}
		}

		return $values;
	}

	protected function get_property_displays() {
		$values = new EntryValues($this->named_property_values);

		$displays = [];
		foreach ($this->properties as $prop) {
			$display = $prop->property->displayValue($prop->value, $values);
			if ( $display !== null ) {
				$displays[$prop->property_id] = new PropertyDisplay($prop->property, $display);
			}
		}

		return $displays;
	}

	protected function relate_properties() {
		return $this->to_many(EntryProperty::class, 'entry_id');
	}

}
