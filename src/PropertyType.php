<?php

namespace rdx\diary;

abstract class PropertyType {

	public $label = 'Property type?';

	abstract public function makeFormHtml( $name, $value = null ) : string;

	public function canFold() : bool {
		return false;
	}

}
