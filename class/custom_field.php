<?php

class CustomField {
	
	private $data = array();

	function __construct( $name, $label, $type ) {
		$defaults = ACFD::getDefaults( $type );
		foreach ( $defaults as $key => $value ) {
			$this->set( $key, $value );
		}
		
		$this->set( 'key', $type . '_' . sha1( $name . $label ) )
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

	function copy( $name, $label = null ) {
		if ( $label == null ) {
			$label = $this->get( 'label' );
		}

		$copy = new CustomField( $name, $label, $this->get( 'type' ) );
		
		foreach ( $this->data as $key => $value ) {
			$copy->set( $key, $value );
		}

		return $copy;
	}

	function setInstructions( $value ) {
		return $this->set( 'instructions', $value );
	}

	function setRequired( $value ) {
		return $this->set( 'required', $value );
	}

	function setConditionalLogic( $value ) {
		return $this->set( 'conditional_logic', $value );
	}

	function setWrapperWidth( $value ) {
		$wrapper = isset( $this->data['wrapper'] ) ? $this->data['wrapper'] : array();
		$wrapper['width'] = $value;
		return $this->set( 'wrapper', $wrapper );
	}

	function setWrapperClass( $value ) {
		$wrapper = isset( $this->data['wrapper'] ) ? $this->data['wrapper'] : array();
		$wrapper['class'] = $value;
		return $this->set( 'wrapper', $wrapper );
	}

	function setWrapperId( $value ) {
		$wrapper = isset( $this->data['wrapper'] ) ? $this->data['wrapper'] : array();
		$wrapper['id'] = $value;
		return $this->set( 'wrapper', $wrapper );
	}
}

