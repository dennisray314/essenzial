<?php

class Cornerstone_Headers extends Cornerstone_Plugin_Component {

  public $header_styles = '';
  public $dependencies = array( 'Coalescence' );
  public $modules = array();
  public $modules_registered = false;

  public function setup() {
    $this->register_post_type();
  }

  public function add_styling( $header, $class_prefix, $template_loader ) {

    $coalescence = $this->plugin->component( 'Coalescence' );
    $coalescence->set_template_loader( $template_loader );
    $coalescence->set_config( array( 'class_prefix' => 'hm' ) );
    $coalescence->prepare( array(
      '_type' => 'root',
      'modules' => $header['modules']
    ) );

    $this->header_styles = $coalescence->run();

  }

  public function get_styles() {
    return $this->header_styles;
  }

  public function register_post_type() {

    register_post_type( 'cs_header', array(
        'public'          => false,
        'capability_type' => 'page',
        'supports'        => false
    ) );

  }

  public function register_modules( $modules ) {

    foreach ($modules as $name => $module) {
      $this->register_module( $name, $module );
    }

  }

  public function register_module( $name, $module ) {

    $module = wp_parse_args( $module, array(
      'title'    => '',
      'defaults' => array(),
      'controls' => array(),
      'control_groups' => array()
    ) );

    $controls = $this->flatten_controls( $module['controls'] );

    if ( isset( $controls['__groups'] ) ) {
      $module['control_groups'] = array_merge( $controls['__groups'], $module['control_groups'] );
      unset( $controls['__groups'] );
    }

    $module['controls'] = array();

    foreach ($controls as $key => $control) {
      $control['name'] = $key;
      $module['controls'][] = $control;
    }

    $this->modules[ $name ] = $module;
  }

  public function flatten_controls( $controls, $group = '' ) {
    $updated_controls = array();

    foreach ( $controls as $key => $control ) {

      $control = wp_parse_args( $control, array(
        'type'    => '',
        'title' => array(),
        'options' => array(),
      ) );

      $parent_group = null;

      if ( $group ) {
        $key = $group . '_' . $key;
        $control['group'] = $group;
        $parent_group = $group;
      }

      if ( 'group' === $control['type'] && isset( $control['controls'] ) ) {
        $child_controls = $this->flatten_controls( $control['controls'], $key );
        $updated_controls = array_merge( $updated_controls, $child_controls );
        if ( ! isset( $updated_controls['__groups'] ) ) {
          $updated_controls['__groups'] = array();
        }

        $updated_controls['__groups'][ $key ] = array(
          'parent' => $parent_group,
          'title' => $control['title']
        );

      } else {
        $updated_controls[ $key ] = $control;
      }

    }

    return $updated_controls;
  }

  public function unregister_module( $name ) {
    unset( $this->modules[ $name ] );
  }

  public function module_registration() {

    if ( $this->modules_registered ) {
      return;
    }

    do_action( 'cornerstone_headers_register_modules' );

    $this->modules_registered = true;

  }

  public function get_modules() {
    $this->module_registration();
    return $this->modules;
  }

}
