<?php

namespace Drupal\super_pomme\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Symfony\Component\DependencyInjection\ContainerInterface; // ajouté
use Drupal\super_pomme\DefaultServiceInterface; // ajouté

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a 'SuperPommeBlock' block.
 *
 * @Block(
 *  id = "super_pomme_block",
 *  admin_label = @Translation("Super pomme block"),
 * )
 */
class SuperPommeBlock extends BlockBase implements ContainerFactoryPluginInterface {
  protected $blockManager;
  
  public function __construct(DefaultServiceInterface $pomme_attribute) {
    $this->blockManager = $pomme_attribute;
  }
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#theme' => 'super_pomme',
      '#tata' => $this->blockManager->fntest('didier et robert'),
    ];
    
    return $build;
  }
  
  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($container->get('super_pomme.default'));
  }
}





