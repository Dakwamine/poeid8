<?php

namespace Drupal\hello\Access;

use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

class HelloMinAccountAgeInHoursAccess implements AccessCheckInterface {

  public function applies(Route $route) {
    return null;
  }

  public function access(Route $route, AccountInterface $account, Request $request = null) {
    if ($account->id() == 0) {
      // Anonymous
      return AccessResult::forbidden();
    }

    $minAgeInHours = $route->getRequirement('_hello_min_account_age_in_hours');

    if (time() - $account->getAccount()->created > 3600 * $minAgeInHours) {
      return AccessResult::allowed();
    }

    return AccessResult::forbidden();
  }

}
