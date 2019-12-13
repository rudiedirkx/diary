<?php

namespace rdx\diary;

class PropertyDisplay {

	public $property;
	public $value;

	public function __construct( Property $property, $value ) {
		$this->property = $property;
		$this->value = $value;
	}

}
