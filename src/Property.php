<?php

namespace rdx\diary;

use db_generic_model;

class Property extends db_generic_model {

	static public $_table = 'properties';

	public function __toString() {
		return $this->name;
	}

}
