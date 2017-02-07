<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Description of HelloConfigForm
 *
 * @author POE3
 */
class HelloConfigForm extends ConfigFormBase {

  protected function getEditableConfigNames(): array {
    return ['hello.config'];
  }

  public function getFormId(): string {
    return 'hello_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['fieldset_calculator'] = [
      '#type' => 'fieldset',
      '#title' => t('Choose cute colors only')
    ];

    $form['fieldset_calculator']['blocks_color'] = [
      '#type' => 'select',
      '#title' => t('Blocks color'),
      '#default_value' => $this->config('hello.config')->get('color')
    ];
    
    $form['fieldset_calculator']['blocks_color'] = array(
      '#type' => 'select',
      '#title' => t('Blocks color'),
      '#description' => t('Choose your color.'),
      '#options' => array(
        'green' => $this->t('Green'),
        'orange' => $this->t('Orange'),
        'blue-class' => $this->t('Blue')
      ),
      '#default_value' => $this->config('hello.config')->get('color')
    );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $blocks_color = $form_state->getValue('blocks_color');
    
    $this->configFactory->getEditable('hello.config')->set('color', $blocks_color);
    $this->configFactory->getEditable('hello.config')->save();
    
    // Reset cache to force new config
    /* @var $tmp \Drupal\block\BlockViewBuilder */
    $tmp = \Drupal::entityTypeManager()->getViewBuilder('block');
    $tmp->resetCache();
    
    parent::submitForm($form, $form_state);
  }

}
