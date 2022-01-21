<?php

namespace rdx\diary\properties;

use rdx\diary\PropertyType;

abstract class InputPropertyType extends PropertyType {

	abstract protected function getInputType() : string;

	protected function getAttributes() : array {
		return [];
	}

	protected function makeAttributes( array $attributes ) {
		$html = '';
		foreach ( $attributes as $name => $value ) {
			$html .= ' ' . $name . '="' . html($value) . '"';
		}

		return $html;
	}

	public function makeFormHtml( $name, $value = null ) : string {
		$attributes = $this->getAttributes();

		$attributes['type'] = $this->getInputType();
		$attributes['name'] = $name;
		$attributes['enterkeyhint'] = 'send';

		if ( $value !== null ) {
			$attributes['value'] = $value;
		}

		$attributes = $this->makeAttributes($attributes);
		return '<input' . $attributes . ' />';
	}

}
