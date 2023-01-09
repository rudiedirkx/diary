<?php

namespace rdx\diary;

class Entry extends Model {

	static public $_table = 'entries';

	static public function byIdOrDate(?int $id, ?string $date) : ?self {
		foreach (compact('id', 'date') as $key => $value) {
			if ($value && $entry = self::first([$key => $value])) {
				return $entry;
			}
		}
		return null;
	}

	public function saveProps( array $props ) {
		$properties = Property::getEnabled();

		$save = [];
		foreach ($props as $id => $value) {
			if ( !isset($properties[$id]) ) continue;
			$property = $properties[$id];

			if ( trim($value) !== '' ) {
				$save[$id] = trim($value);
			}
		}

		self::$_db->delete(EntryProperty::$_table, [
			'entry_id' => $this->id,
			'property_id' => array_keys($properties),
		]);
		foreach ($save as $id => $value) {
			$properties[$id]->saveProp($this, $value);
		}
	}

	public function hasProperty(int $pid) : bool {
		return (bool) ($this->property_values[$pid] ?? null);
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
		$idValues = $this->property_values;
		$nameValues = new EntryValues($this->named_property_values);
		$all = Property::getAll();

		$displays = [];
		foreach ( $all as $prop ) {
			$value = $idValues[$prop->id] ?? null;
			if ( $prop->render_always || $value != null ) {
				$display = $prop->displayValue($value, $nameValues);
				if ( $display !== null ) {
					$displays[$prop->id] = new PropertyDisplay($prop, $display);
				}
			}
		}

		return $displays;
	}

	protected function relate_properties() {
		return $this->to_many(EntryProperty::class, 'entry_id');
	}

}
