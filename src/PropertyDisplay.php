<?php

namespace rdx\diary;

class PropertyDisplay {

	public $property;
	public $value;
	public $html_value;

	public function __construct( Property $property, $value ) {
		$this->property = $property;
		$this->value = $value;
		$this->html_value = nl2br(html(trim($value)));
	}

}
