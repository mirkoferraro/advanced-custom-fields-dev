<?php

add_action( 'admin_print_scripts', 'print_full_hide_on_screen_style' );
function print_full_hide_on_screen_style() {

	$style = "";
	$field_groups = acf_get_field_groups();

	if ( ! empty( $field_groups ) ) {
		foreach( $field_groups as $i => $field_group ) {
			$style .= acf_get_field_group_style( $field_group );
		}
	}
	
	echo '<style type="text/css" id="acfd-style">' . $style . '</style>';
}