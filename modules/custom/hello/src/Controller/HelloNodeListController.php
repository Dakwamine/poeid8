<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloNodeListController extends ControllerBase {

  public function content($nodeType) {
    // Check node type validity
    
    
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
        $ids = \Drupal::entityQuery('node')->condition('type', $nodeType)->pager(15)->execute();
        $entities = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($ids);
        
        $content = [];
        
        foreach($entities as $e) {
          $content[] = $e->toLink();
          //$content[] = Link::createFromRoute($node->label(), 'entity.node.canonical', array('node' => $node->id()));
        }
        //kint($content);die();
        
        $list = array('#theme' => 'item_list', '#items' => $content);
        $pager = array('#type' => 'pager');
        
        return array($list, $pager);
    }
  }

}
