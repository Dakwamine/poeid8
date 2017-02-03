<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxy;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * 
 * @Block(
 *  id = "hello_block",
 *  admin_label = @Translation("Block Hello!")
 * )
 */
class Hello extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Drupal date formatter.
   * @var Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;
  
  /**
   * User info.
   * @var Drupal\Core\Session\AccountProxy
   */
  protected $accountProxy;

  public function __construct(DateFormatter $date_formatter, AccountProxy $account_proxy, array $configuration, $plugin_id, $plugin_definition) {
    $this->dateFormatter = $date_formatter;
    $this->accountProxy = $account_proxy;
    
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * Implements Drupal\Core\Block\BlockBase::build()
   */
  public function build(): array {
    $markup = $this->t(
      'Welcome to our site, @username. It is @time.',
      array(
        '@username' => $this->accountProxy->getAccountName(),
        '@time' => $this->dateFormatter->format(time(), 'html_time')
      )
    );
    
    $build = array(
      '#markup' => $markup,
      '#cache' => array(
        'keys' => ['hello'],
        'contexts' => ['user'],
        'max-age' => '10000'
      )
    );

    return $build;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
        $container->get('date.formatter'),
        $container->get('current_user'),
        $configuration, $plugin_id, $plugin_definition);
  }

}
