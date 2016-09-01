<?php

class CustomField {
	
	private $data = array();

	function __construct( $name, $label, $type ) {
		$defaults = ACFED::getDefaults( $type );
		foreach ( $defaults as $key => $value ) {
			$this->set( $key, $value );
		}
		
		$this->set( 'key', $type . '_' . sha1($name) )
			->set( 'name', $name )
			->set( 'label', $label )
			->set( 'type', $type );
	}

	function set( $key, $value ) {
		$this->data[$key] = $value;
		return $this;
	}

	function get( $key = null ) {
		if ( $key != null ) {
			return isset( $this->data[$key] ) ? $this->data[$key] : null;
		}

		return $this->data;
	}
}

