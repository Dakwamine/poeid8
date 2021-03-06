<?php

namespace Drupal\yamlform_devel\Plugin\YamlFormHandler;

use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Form\FormStateInterface;
use Drupal\yamlform\YamlFormHandlerBase;
use Drupal\yamlform\YamlFormSubmissionInterface;

/**
 * Form submission debug handler.
 *
 * IMPORTANT: This handler is exactly the same as the one in the
 * yamlform_test.module. It does not really matter which one is loaded.
 *
 * @YamlFormHandler(
 *   id = "debug",
 *   label = @Translation("Debug"),
 *   category = @Translation("Development"),
 *   description = @Translation("Debug form submission."),
 *   cardinality = \Drupal\yamlform\YamlFormHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\yamlform\YamlFormHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class DebugYamlFormHandler extends YamlFormHandlerBase {

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state, YamlFormSubmissionInterface $yamlform_submission) {
    $build = ['#markup' => 'Submitted values are:<pre>' . Yaml::encode($yamlform_submission->getData()) . '</pre>'];
    drupal_set_message(\Drupal::service('renderer')->render($build), 'warning');
  }

}
