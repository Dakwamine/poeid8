<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * 
 * @Block(
 *  id = "hello_database_block",
 *  admin_label = @Translation("Active Sessions")
 * )
 */
class HelloDatabase extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Contains the database service.
   * @var Connection
   */
  protected $database;

  public function __construct(Connection $database_t, array $configuration, $plugin_id, $plugin_definition) {
    $this->database = $database_t;

    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  public function build(): array {
    // Get active sessions count
    $result = $this->database
            ->select('sessions', 's')
            ->fields('s', array('uid'))
            ->countQuery()
            ->execute()->fetchField();

    switch ($result) {
      case '0':
        $markup = $this->t('There is no active session.');
        break;

      case '1':
        $markup = $this->t('There is one active session.');
        break;

      default:
        $markup = $this->t('There are @n active sessions.', array('@n' => $result));
        break;
    }

    $build = array('#markup' => $markup);

    return $build;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
        $container->get('database'), $configuration, $plugin_id, $plugin_definition);
  }

  protected function blockAccess(AccountInterface $account) {
    if($account->hasPermission('hello.block.database.access')) {
      return AccessResult::allowed();
    }
    
    return AccessResult::forbidden();
  }

}
