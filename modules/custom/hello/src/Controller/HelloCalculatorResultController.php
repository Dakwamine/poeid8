<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloCalculatorResultController extends ControllerBase {

  public function content($result) {
    return array(
      '#markup' => $this->t(
          'The result is: @formattedBlob', array('@formattedBlob' => $result)
      )
    );
  }

}
