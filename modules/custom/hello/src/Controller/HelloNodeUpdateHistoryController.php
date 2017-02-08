<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Entity\EntityTypeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloNodeUpdateHistoryController extends ControllerBase {

  /**
   * @var Connection
   */
  protected $database;

  /**
   * @var EntityTypeManager
   */
  protected $entityTypeManager;

  public function __construct(Connection $database, EntityTypeManager $entity_type_manager, DateFormatter $date_formatter) {
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
    $this->dateFormatter = $date_formatter;
  }

  public function content(int $node) {
    $result = $this->database
            ->select('hello_node_history', 'hnh')
            ->fields('hnh', array('uid', 'update_time'))
            ->condition('nid', $node)
            ->execute()->fetchAll();

    if (count($result) != 0) {
      $userids = [];

      foreach ($result as $r) {
        $userids[] = $r->uid;
      }

      // Service for user name
      /* @var Drupal\user\Entity\User */
      $entities = $this->entityTypeManager->getStorage('user')->loadMultiple($userids);

      $rows = [];

      foreach ($result as $r) {
        //$rows[] = array($entities[$r->uid]->label(), $r->update_time);
        $rows[] = array($entities[$r->uid]->label(), $this->dateFormatter->format($r->update_time, 'medium'));
      }

      $table = array(
        '#theme' => 'table',
        '#header' => array('Username', 'Updated on'),
        '#rows' => $rows
      );
      
      // Get node name
      $nodeobj = $this->entityTypeManager->getStorage('node')->load($node);
      $nodename = $nodeobj->get('title')->getString();

      // Updates count render array, markup style
      /*$updatesCount = [];

      switch (count($result)) {
        case 1:
          $updatesCount = array(
            '#markup' => $this->t(
              'The node <em>@nodename</em> has been updated once.',
              array('@nodename' => $nodename)
            )
          );
          break;

        default:
          $updatesCount = array(
            '#markup' => $this->t(
              'The node <em>@nodename</em> has been updated @count times.',
              array('@nodename' => $nodename, '@count' => count($result))
            )
          );
          break;
      }*/
      
      // Updates count render array, hook_theme style
      $updatesCount = [
        '#theme' => 'hello_node_history',
        '#nodename' => $nodename,
        '#count' => count($result)
      ];
      
      return array($updatesCount, $table);
    }
    else {
      return array('#markup' => $this->t('There is no update history for this node.'));
    }
  }

  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('database'), $container->get('entity_type.manager'), $container->get('date.formatter')
    );
  }

}
