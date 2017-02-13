<?php

namespace Drupal\annonce\Entity\EventSubscriber;

use Drupal\Core\Database\Connection;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function drupal_set_message;

class AnnonceSubscriber implements EventSubscriberInterface {

  /**
   * Current user service.
   * @var AccountProxy
   */
  protected $currentUser;

  /**
   * Drupal\Core\Routing\CurrentRouteMatch definition.
   *
   * @var CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * Database access service
   *
   * @var Connection
   */
  protected $database;

  public function __construct(AccountProxy $current_user, CurrentRouteMatch $current_route_match, Connection $database) {
    $this->currentUser = $current_user;
    $this->currentRouteMatch = $current_route_match;
    $this->database = $database;
  }

  static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['kernel_request'];
    return $events;
  }

  /**
   * Log user visit on the current annonce
   *
   * @param GetResponseEvent $event
   */
  public function kernel_request(Event $event) {
    if ($this->currentRouteMatch->getRouteObject()->getDefault('_entity_view') == 'annonce') {
      drupal_set_message(t('Events for @username in annonce.', ['@username' => $this->currentUser->getDisplayName()]), 'status', TRUE);


      // Get currently visited annonce id
      /* @var $currentAnnonce \Drupal\annonce\Entity\Annonce */
      $currentAnnonce = $this->currentRouteMatch->getParameter('annonce');


      // Check if entry was already added
      $result = $this->database
              ->select('annonce_history', 'ah')
              ->fields('ah', array('uid'))
              ->condition('uid', $this->currentUser->id())
              ->condition('annonce_id', $currentAnnonce->id())
              ->range(0, 1)
              ->execute()->fetchAll();

      if (count($result) == 0) {
        // Add entry
        $this->database
            ->insert('annonce_history')
            ->fields(['uid', 'annonce_id', 'access_time'], [$this->currentUser->id(), $currentAnnonce->id(), time()])
            ->execute();
      }
      else {
        // Update entry
        $this->database
            ->update('annonce_history')
            ->fields(['access_time' => time()])
            ->condition('uid', $this->currentUser->id())
            ->condition('annonce_id', $currentAnnonce->id())
            ->execute();
      }
    }
  }

}
