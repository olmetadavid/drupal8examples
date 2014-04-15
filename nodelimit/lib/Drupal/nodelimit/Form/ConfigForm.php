<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 15/04/2014
 * Time: 21:31
 */

namespace Drupal\nodelimit\Form;

use Drupal\Core\Form\ConfigFormBase;

/**
 * Class ConfigForm
 * @package Drupal\nodelimit\Form
 *
 * Represents the form configuration.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'nodelimit_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {

    // Get the config object.
    $config = \Drupal::config('nodelimit.settings');

    // Add the form component.
    $form['limit'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Limit for node creation.'),
      '#description' => $this->t('Enter the limit of node creation for this type.'),
      '#default_value' => $config->get('limit'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, array &$form_state) {
    if ( ((int)$form_state['values']['limit']) <= 0 ) {
      $this->setFormError('limit', $form_state, $this->t('You should enter a number upper to 0.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    $config = \Drupal::config('nodelimit.settings');
    $config->set('limit', $form_state['values']['limit']);
    $config->save();
  }
} 