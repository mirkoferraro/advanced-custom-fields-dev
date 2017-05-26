<?php
/*
Plugin Name: Advanced Custom Fields Development
Plugin URI: https://github.com/mirkoferraro/advanced-custom-fields-dev
Description: Makes the ACF registration via PHP easier
Version: 1.0.6
Author: Mirko Ferraro
Author URI: http://www.mirkoferraro.it
Copyright: Mirko Ferraro
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACFD {

	static private $menu_order = 1;
	static private $defaults   = array();
	static private $queue      = array();

	static function init() {
		add_action( 'plugins_loaded', array( get_called_class(), 'check_dependencies' ) );
	}

	static function check_dependencies() {
		if ( ! class_exists('acf') ) {
			add_action( 'admin_notices', array( get_called_class(), 'admin_notice_acf_required' ) );
			return;
		}

		include( 'class/custom_field.php' );
		include( 'class/custom_field_container.php' );
		include( 'class/custom_group.php' );
		include( 'class/custom_module.php' );
		include( 'class/widget.php' );

		include( 'includes/hide_on_screen_fix.php' );

		add_action( 'acf/init', array( get_called_class(), 'registerGroups' ) );
		add_action( 'init', array( get_called_class(), 'registerGroups' ) );
	}

	static function isActive() {
		return class_exists( 'acf' );
	}

	static function admin_notice_acf_required() {
    	?>
	    <div class="notice notice-error is-dismissible">
	        <p><?= __( 'Advanced Custom Fields Easy Development require Advanced Custom Field in order to work', 'acfed' ); ?></p>
	    </div>
	    <?php
	}

	static function getContainerFieldName( $type ) {
		switch ( $type ) {
			case 'repeater': return 'sub_fields';
			case 'flexible_content': return 'layouts';
			case 'flexible_item': return 'sub_fields';
			default: return 'fields';
		}
	}

	static function getDefaults( $type ) {
		return isset( self::$defaults[ $type ] ) ? self::$defaults[ $type ] : array();
	}

	static function setDefaults( $type, $data ) {
		self::$defaults[ $type ] = $data;
	}

	static function field( $name, $label, $type ) {
		return new CustomField( $name, $label, $type );
	}

	static function container( $name, $label, $type, $field_name = 'fields' ) {
		return new CustomFieldContainer( $name, $label, $type, $field_name );
	}

	static function group( $name, $location = 'options_page == acf-options' ) {
		return new CustomGroup( $name, $location );
	}

	static function module() {
		return new CustomModule();
	}

	static function addGroup( $group ) {
		self::$queue[] = $group;
	}

	private static function _acfLocalGroup( $group ) {

		if ( ! count( $group->getFields() ) ) {
			return false;
		}

		$group_data = $group->get();

		if ( ! isset( $group_data['menu_order'] ) ) {
			$group_data['menu_order'] = self::$menu_order++;
		}
		
		// Throws exception if ACF is not loaded
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			throw new Exception( 'Advanced Custom Field not loaded' );
		}

		// Create ACF Options page if used
		foreach ( $group_data['location'] as &$group ) {
			foreach ($group as &$rule) {
				if ( $rule['param'] == 'options_page' && $rule['operator'] == '==' ) {
					if ( strpos( $rule['value'], 'acf-options-' ) === 0 ) {
						acf_add_options_sub_page( substr( $rule['value'], 12 ) );
						$rule['value'] = strtolower( $rule['value'] );
					} else {
						acf_add_options_page();
					}
				}
			}
		}

		acf_add_local_field_group( $group_data );

		return true;
	}

	static function registerGroup( $key ) {
		foreach ( self::$queue as $key => $group ) {
			if ( $key == $group->get( 'key' ) ) {
				if ( self::_acfLocalGroup( $group ) ) {
					unset( self::$queue[$key] );
					return true;
				}

				return false;
			}
		}

		return false;
	}

	static function registerGroups() {
		foreach ( self::$queue as $key => $group ) {
			if ( self::_acfLocalGroup( $group ) ) {
				unset( self::$queue[$key] );
			}
		}
	}
}

ACFD::init();
