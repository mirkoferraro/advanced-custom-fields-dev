<?php
/*
Plugin Name: Advanced Custom Fields Easy Development
Plugin URI: http://www.mirkoferraro.it
Description: Makes the ACF registration via PHP easier
Version: 1.0.0
Author: Mirko Ferraro
Author URI: http://www.mirkoferraro.it
Copyright: Mirko Ferraro
*/

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACFED {

	static private $menu_order = 1;
	static private $defaults = array();
	static private $groups = array();

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
		include( 'class/widget.php' );

		add_action('acf/init', array( get_called_class(), 'registerGroups' ) );
	}

	static function is_active() {
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
			default: return 'fields';
		}
	}

	static function getDefaults( $type ) {
		return isset( self::$defaults[ $type ] ) ? self::$defaults[ $type ] : array();
	}

	static function setDefaults( $type, $data ) {
		self::$defaults[ $type ] = $data;
	}

	static function addGroup( $group ) {
		self::$groups[] = $group;
	}

	static function registerGroups() {
		// Throws exception if ACF is not loaded
		if ( ! function_exists('acf_add_local_field_group') ) {
			throw new Exception('Advanced Custom Field not loaded');
		}

		foreach ( self::$groups as $group ) {

			if ( ! $group->is_valid() ) {
				continue;
			}
			
			$group_data = $group->get();

			if ( ! isset( $group_data['menu_order'] ) ) {
				$group_data['menu_order'] = self::$menu_order++;
			}

			acf_add_local_field_group( $group_data );

			// Create ACF Options page if used
			foreach ( $group_data['location'] as $group ) {
				foreach ($group as $rule) {
					if ( $rule['param'] == 'options_page' && $rule['operator'] == '==' ) {
						if ( strpos( $rule['value'], 'acf-options-' ) === 0 ) {
							acf_add_options_sub_page( substr( $rule['value'], 12 ) );
						} else {
							acf_add_options_page();
						}
					}
				}
			}
		}

	}
}

ACFED::init();