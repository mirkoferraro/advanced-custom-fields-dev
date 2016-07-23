<?php

class CustomFieldContainer extends CustomField {
	
	private $fields = array();
	private $field_name;

	function __construct( $name, $label, $type, $field_name = 'fields' ) {
		parent::__construct( $name, $label, $type );
		$this->field_name = $field_name;
	}

	function get( $key = null ) {
		if ( $key != null ) {
			if ( $key == $this->field_name ) {
				return $fields;
			}

			return parent::get( $key );
		}

		$data = parent::get();
		$data[ $this->field_name ] = $this->getFieldsData();
		return $data;
	}

	function is_valid() {
		return !! count( $this->fields );
	}

	function getFields() {
		return $this->fields;
	}

	function getFieldsData() {
		$fields_data = array();

		foreach ( $this->fields as $field ) {
			if ( $field->is_valid() ) {
				$fields_data[] = $field->get();
			}
		}

		return $fields_data;
	}

	function addField( $name, $label, $type ) {
		$field = new CustomField( $name, $label, $type );
		$this->fields[] = $field;
		return $field;
	}

	function addContainer( $name, $label, $type, $field_name = null ) {
		if ( $field_name == null ) {
			$field_name = ACFED::getContainerFieldName( $type );
		}

		$field = new CustomFieldContainer( $name, $label, $type, $field_name );
		$this->fields[] = $field;
		return $field;
	}
	
}

