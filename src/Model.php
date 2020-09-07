<?php

namespace rdx\diary;

use db_generic_model;

class Model extends db_generic_model {

	static function presave( array &$data ) {
		parent::presave($data);

		self::presaveTrim($data);
	}

}
