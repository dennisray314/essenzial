<?php

class Cornerstone_Controller_Headers extends Cornerstone_Plugin_Component {

  public function config() {

    return array(
      'i18n' => $this->plugin->i18n( 'headers' )
    );

  }
}
