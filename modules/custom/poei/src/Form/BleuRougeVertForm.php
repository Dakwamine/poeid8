<?php

namespace Drupal\poei\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BleuRougeVertForm.
 *
 * @package Drupal\poei\Form
 */
class BleuRougeVertForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'poei.bleurougevert',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bleu_rouge_vert_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('poei.bleurougevert');
    $form['couleur'] = [
      '#type' => 'select',
      '#title' => $this->t('couleur'),
      '#description' => $this->t('choisozeuhgiez gkzg hir'),
      '#options' => array('rouge' => $this->t('rouge'), 'vert' => $this->t('vert'), 'bleu' => $this->t('bleu')),
      '#size' => 1,
      '#default_value' => $config->get('couleur'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('poei.bleurougevert')
      ->set('couleur', $form_state->getValue('couleur'))
      ->save();
  }

}
