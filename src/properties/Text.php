<?php

namespace rdx\diary\properties;

class Text extends InputPropertyType {

	public $label = 'Text';

	protected function getInputType() : string {
		return 'text';
	}

}
