<?php

class CustomModule extends CustomFieldContainer {

	function __construct() {
	}

	function get( $key = null ) {
		if ( $key != null ) {
			if ( $key == $this->field_name ) {
				return $fields;
			}

			return parent::get( $key );
		}

		return $this->getFieldsData();
	}

}


