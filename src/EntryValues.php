<?php

namespace rdx\diary;

class EntryValues {

	public function __construct( array $values ) {
		foreach ( $values as $key => $value ) {
			$this->$key = $value;
		}
	}

	public function __get( $name ) {
		return null;
	}

}
