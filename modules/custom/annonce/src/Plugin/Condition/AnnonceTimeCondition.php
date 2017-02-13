<?php

namespace Drupal\annonce\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;

/**
 * Provides a 'Annonce time condition' condition to enable a condition based in module selected status.
 *
 * @Condition(
 *   id = "annonce_time_condition",
 *   label = @Translation("Annonce time condition")
 * )
 *
 */
class AnnonceTimeCondition extends ConditionPluginBase {

  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['date_1'] = array(
      '#type' => 'date',
      '#title' => 'Min date',
      '#description' => t('Delete to remove this date condition'),
      '#default_value' => $this->configuration['date_1']
    );

    $form['date_2'] = array(
      '#type' => 'date',
      '#title' => 'Max date',
      '#description' => t('Delete to remove this date condition'),
      '#default_value' => $this->configuration['date_2']
    );

    return $form;//parent::buildConfigurationForm($form, $form_state);
  }

  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['date_1'] = $form_state->getValue('date_1');
    $this->configuration['date_2'] = $form_state->getValue('date_2');
//    kint($form);
//    kint($form_state);
//    kint($form_state->getValue('date_1'));
//    die;

    //parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['date_1' => '', 'date_2' => ''];// + parent::defaultConfiguration();
  }

  public function evaluate(): bool {
    if (!empty($this->configuration['date_1']) && !empty($this->configuration['date_2'])) {
      if (time() > strtotime($this->configuration['date_1']) && time() < strtotime($this->configuration['date_2'])) {
        // Today is After date_1 and Before date_2
        //kint('Today is between date_1 and date_2');
        return true;
      }
      else {
        // Today is Before date_1
        //kint('Today is either before date_1 or after date_2');
        return false;
      }
    }
    elseif (!empty($this->configuration['date_1'])) {
      if (strtotime($this->configuration['date_1']) < time()) {
        // Today is After date_1
        //kint('Today is After date_1');
        return true;
      }
      else {
        // Today is Before date_1
        //kint('Today is Before date_1');
        return false;
      }
    }
    elseif (!empty($this->configuration['date_2'])) {
      if (strtotime($this->configuration['date_2']) > time()) {
        // Today is Before date_2
        //kint('Today is Before date_2');
        return true;
      }
      else {
        // Today is After date_2
        //kint('Today is After date_2');
        return false;
      }
    }
    else {
      return true;
    }
  }

  /**
   * Provides a human readable summary of the condition's configuration.
   */
  public function summary() {
    
  }

}
