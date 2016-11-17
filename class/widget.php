<?php

class ACF_Widget extends WP_Widget {

	public function __construct( $id_base, $name, $widget_options = array(), $control_options = array() ) {
		parent::__construct( $id_base, $name, $widget_options, $control_options );
	}

	public function get_acf_id() {
		return "widget_" . $this->id;
	}

	public function form( $instance ) {
		return '';
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$this->acf_widget( $this->get_acf_id() );

		echo $args['after_widget'];
	}

	public function acf_widget( $acf_id ) {
		die('function ACF_Widget::acf_widget() must be over-ridden in a sub-class.');
	}
}