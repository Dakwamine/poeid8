<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\Query\QueryFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloNodeListController extends ControllerBase {

  /**
   * @var Drupal\Core\Entity\Query\QueryFactory
   */
  protected $queryFactory;

  /**
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  public function __construct(QueryFactory $query_factory, EntityTypeManager $entity_type_manager) {
    $this->queryFactory = $query_factory;
    $this->entityTypeManager = $entity_type_manager;
  }

  public function content($nodeType) {
    switch ($nodeType) {
      case '':
        return array(
          '#markup' => $this->t(
              'You are on the Formation page. Your username is @username.', array(
            '@username' => $this->currentUser()->getAccountName()
              )
          )
        );

      default:
        // Load page nodes
        $ids = $this->queryFactory->get('node')->condition('type', $nodeType)->pager(15)->execute();
        $entities = $this->entityTypeManager->getStorage('node')->loadMultiple($ids);

        $content = [];

        foreach ($entities as $e) {
          // The easy way
          $content[] = $e->toLink();
          
          // The hard way
          //$content[] = Link::createFromRoute($node->label(), 'entity.node.canonical', array('node' => $node->id()));
        }

        $list = array('#theme' => 'item_list', '#items' => $content);
        $pager = array('#type' => 'pager');

        return array($list, $pager);
    }
  }

  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('entity.query'), $container->get('entity_type.manager')
    );
  }

}
