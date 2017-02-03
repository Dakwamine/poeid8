<?php

namespace Drupal\super_pomme;

/**
 * Class DefaultService.
 *
 * @package Drupal\super_pomme
 */
class DefaultService implements DefaultServiceInterface {

  /**
   * Constructor.
   */
  public function __construct() {

  }
  
  public function fntest($param1) {
    echo 'azerty' . $param1;
  }
}
