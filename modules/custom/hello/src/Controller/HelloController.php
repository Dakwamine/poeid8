<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {
  public function content($blob) {
    if($blob != '') {
      return array(
        '#markup' => $this->t(
          'You are on the Hello page. Your username is @username, and here is the parameter in the URL: @formattedBlob',
          array(
            '@username' => $this->currentUser()->getAccountName(),
            '@formattedBlob' => $blob
          )
        )
      );
    }
    else {
      return array(
        '#markup' => $this->t(
          'You are on the Hello page. Your username is @username.',
          array(
            '@username' => $this->currentUser()->getAccountName()
          )
        )
      );
    }
  }
}
