<?php

class Cornerstone_Controller_Options extends Cornerstone_Plugin_Component {

  public function config() {

    $options = $this->plugin->loadComponent( 'Options_Manager' );

    return array(
      'i18n' => $this->plugin->i18n( 'options' ),
      'customCSSKey' => $options->get_custom_css_key(),
      'customJSKey' => $options->get_custom_js_key(),
      'title' => apply_filters( 'cornerstone_options_theme_title', false ) ? 'title-theme' : 'title-default',
    );

  }

  public function save( $data ) {

    $options = $this->plugin->loadComponent( 'Options_Bootstrap' );
    $response = array( 'updates' => array() );

    if ( isset( $data['updates'] ) ) {
      foreach ($data['updates'] as $key => $value) {

        $response['updates'][ $key ] = $value;
        $options->update_value( $key, $value );
      }
    }

    return $response;
  }

}
