<?php

namespace rdx\diary\properties;

class Time extends InputPropertyType {

	public $label = 'Time';

	protected function getInputType() : string {
		return 'time';
	}

}
