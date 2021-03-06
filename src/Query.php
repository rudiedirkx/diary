<?php

namespace rdx\diary;

class Query extends Model {

	static public $_table = 'queries';

	protected function get_sql() {
		$ids = array_column(Property::all('machine_name IS NOT NULL'), 'id', 'machine_name');
		return preg_replace_callback('#<<([^,> ]+(?:,\s*[^,> ]+)*)>>#', function($match) use ($ids) {
			return implode(', ', array_map(function($name) use ($ids) {
				return $ids[trim($name)] ?? 0;
			}, explode(',', $match[1])));
		}, $this->query);
	}

}
