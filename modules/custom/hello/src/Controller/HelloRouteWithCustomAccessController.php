<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloRouteWithCustomAccessController extends ControllerBase {

  public function content() {
    return array(
      '#markup' => $this->t(
          'You are on the Hello page. Your username is @username.', array(
        '@username' => $this->currentUser()->getAccountName()
          )
      )
    );
  }

}
