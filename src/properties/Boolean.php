<?php

namespace rdx\diary\properties;

use rdx\diary\PropertyType;

class Boolean extends PropertyType {

	public $label = 'Boolean';

	public function makeFormHtml( $name, $value = null ) : string {
		$checked = $value ? ' checked' : '';
		return '<input type="checkbox" name="' . $name . '" value="1" ' . $checked . ' />';
	}

	public function canFold() : bool {
		return true;
	}

}
