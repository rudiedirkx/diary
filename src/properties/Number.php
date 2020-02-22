<?php

namespace rdx\diary\properties;

class Number extends InputPropertyType {

	public $label = 'Number';

	public function __construct( $decimals = 0, $label = null ) {
		$this->decimals = $decimals;
		if ( $label ) {
			$this->label = $label;
		}
	}

	protected function getInputType() : string {
		return 'number';
	}

	protected function getAttributes() : array {
		return [
			'min' => '0',
			'step' => number_format(1 / pow(10, $this->decimals), $this->decimals),
		];
	}

}
