<?php

namespace rdx\diary;

class EntryProperty extends Model {

	static public $_table = 'entries_properties';

	protected function relate_entry() {
		return $this->to_one(Entry::class, 'entry_id');
	}

	protected function relate_property() {
		return $this->to_one(Property::class, 'property_id');
	}

}
