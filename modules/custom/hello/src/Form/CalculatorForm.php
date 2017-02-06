<?php

namespace Drupal\hello\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use function drupal_set_message;

/**
 * Description of HelloCalculatorForm
 *
 * @author POE3
 */
class CalculatorForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['fieldset_calculator'] = [
      '#type' => 'fieldset',
      '#title' => t('Calculate here')
    ];

    $form['fieldset_calculator']['first_value'] = array(
      '#type' => 'textfield',
      '#title' => t('First value'),
      '#description' => t('Enter first value.'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => [$this, 'validateFirstValue'],
        'event' => 'change'
      ],
      '#suffix' => '<span id="edit-first-value-text-message"></span>'
    );

    $form['fieldset_calculator']['operator'] = array(
      '#type' => 'select',
      '#title' => t('Operation'),
      '#description' => t('Choose operation for processing.'),
      '#options' => array(
        '1' => $this->t('Add'),
        '2' => $this->t('Substract'),
        '3' => $this->t('Multiply'),
        '4' => $this->t('Divide')
      )
    );

    $form['fieldset_calculator']['second_value'] = array(
      '#type' => 'textfield',
      '#title' => t('Second value'),
      '#description' => t('Enter second value.'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => [$this, 'validateSecondValue'],
        'event' => 'change'
      ],
      '#suffix' => '<span id="edit-second-value-text-message"></span>'
    );

    $form['fieldset_calculator']['result_type'] = array(
      '#type' => 'select',
      '#title' => t('Result type'),
      '#description' => t('Choose the way to get the result.'),
      '#options' => array(
        '1' => $this->t('Message'),
        '2' => $this->t('Another page'),
        '3' => $this->t('Field in this form')
      )
    );

    $form['fieldset_calculator']['submit_button'] = array(
      '#type' => 'submit',
      '#value' => t('Calculate')
    );

    $tmp_result_value = $form_state->getTemporaryValue('tmp_result_value');
    if (is_numeric($tmp_result_value)) {
      $form['fieldset_result'] = [
        '#type' => 'fieldset',
        '#title' => t('Result')
      ];

      $form['fieldset_result']['result_value'] = [
        //'#type' => 'markup', // <= valeur par défaut
        '#markup' => $this->t('The result is: @result', ['@result' => $tmp_result_value]),
      ];
    }

    return $form;
  }

  public function getFormId(): string {
    return 'hello_calculator';
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $first_value = $form_state->getValue('first_value');
    if (!is_numeric($first_value)) {
      $form_state->setErrorByName('first_value', t('Field must be numeric!'));
    }

    $second_value = $form_state->getValue('second_value');
    if (!is_numeric($second_value)) {
      $form_state->setErrorByName('second_value', t('Field must be numeric!'));
    }

    $operator = $form_state->getValue('operator');
    if ($operator == 4 && $second_value == 0) {
      $form_state->setErrorByName('second_value', t('Cannot divide by zero, dummy!'));
    }

    if ($operator > 4 || $operator < 1) {
      $form_state->setErrorByName('operator', t('Invalid value!'));
    }

    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $first_value = $form_state->getValue('first_value');
    $operator = $form_state->getValue('operator');
    $second_value = $form_state->getValue('second_value');

    $result = 0;

    switch ($operator) {
      case 1:
        $result = $first_value + $second_value;
        break;

      case 2:
        $result = $first_value - $second_value;
        break;

      case 3:
        $result = $first_value * $second_value;
        break;

      case 4:
        $result = $first_value / $second_value;
        break;
    }

    switch ($form_state->getValue('result_type')) {
      case 1:
        drupal_set_message(t('Result is: @result', array('@result' => $result)));


        // Rebuilds the form with the same values
        $form_state->setRebuild();
        break;

      case 2:
        $form_state->setRedirect('hello.calculator.result', ['result' => $result]);
        break;

      case 3:
        // Save result to temporary value
        $form_state->setTemporaryValue(['tmp_result_value'], $result);


        // Rebuilds the form with the same values
        $form_state->setRebuild();

        break;
    }
  }

  private function validateNumericValue(array &$form, FormStateInterface $form_state, $field_id) {
    $fieldIdAsHtmlId = str_replace('_', '-', $field_id);
    $value = $form_state->getValue($field_id);

    $response = new AjaxResponse();

    if (is_numeric($value)) {
      $response->addCommand(new CssCommand('#edit-' . $fieldIdAsHtmlId, ['border' => '2px solid green']));
      $response->addCommand(new HtmlCommand('#edit-' . $fieldIdAsHtmlId . '-text-message', ''));
    }
    else {
      $response->addCommand(new CssCommand('#edit-' . $fieldIdAsHtmlId, ['border' => '2px solid red']));
      $response->addCommand(new HtmlCommand('#edit-' . $fieldIdAsHtmlId . '-text-message', t('Value is not numeric!')));
    }

    return $response;
  }

  public function validateFirstValue(array &$form, FormStateInterface $form_state) {
    return $this->validateNumericValue($form, $form_state, 'first_value');
  }

  public function validateSecondValue(array &$form, FormStateInterface $form_state) {
    return $this->validateNumericValue($form, $form_state, 'second_value');
  }

}
