<?php

namespace rdx\diary;

use db_generic_model;

class Entry extends db_generic_model {

	static public $_table = 'entries';

	protected function relate_properties() {
		return $this->to_many(EntryProperty::class, 'entry_id');
	}

}
