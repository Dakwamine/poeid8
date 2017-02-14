<?php

namespace Drupal\email_form\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountProxy;
use Drupal\reusable_forms\Form\ReusableFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the EmailForm class.
 */
class EmailForm extends ReusableFormBase implements ContainerInjectionInterface {

  /**
   * Database object.
   * @var Connection
   */
  private $database;

  /**
   * Current Route Match object to get the visited node id.
   * @var CurrentRouteMatch
   */
  private $currentRouteMatch;

  /**
   * Current user service.
   * @var AccountProxy
   */
  protected $currentUser;

  public function __construct(Connection $database, CurrentRouteMatch $current_route_match, AccountProxy $current_user) {
    $this->database = $database;
    $this->currentRouteMatch = $current_route_match;
    $this->currentUser = $current_user;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('database'), $container->get('current_route_match'), $container->get('current_user'));
  }

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'email_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email'),
    );

    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission.
//    kint($form_state);
//    kint($this->database);
//    kint($this->currentRouteMatch->getParameter('node')->id());die;
    //kint($form_state->getValue('email'));die;

    $currentNode = $this->currentRouteMatch->getParameter('node');

    $result = $this->database
            ->select('email_form_registered_emails', 'efre')
            ->fields('efre', array('uid'))
            ->condition('uid', $this->currentUser->id())
            ->condition('nid', $currentNode->id())
            ->range(0, 1)
            ->execute()->fetchAll();

    if (count($result) == 0) {
      // Add entry
      $this->database
          ->insert('email_form_registered_emails')
          ->fields(['uid', 'nid', 'email'], [$this->currentUser->id(), $currentNode->id(), $form_state->getValue('email')])
          ->execute();
    }
    else {
      // Update entry
      $this->database
          ->update('email_form_registered_emails')
          ->fields(['email' => $form_state->getValue('email')])
          ->condition('uid', $this->currentUser->id())
          ->condition('nid', $currentNode->id())
          ->execute();
    }
  }

}
