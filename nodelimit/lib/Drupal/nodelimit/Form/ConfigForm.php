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

    // Add the form components.
    $node_types = node_type_get_names();
    foreach ($node_types as $type => $name) {
      $form['limit_' . $type] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Limit for node creation of type @type.', array('@type' => $type)),
        '#description' => $this->t('Enter the limit of node creation for this type.'),
        '#default_value' => $config->get('limit_' . $type),
      );
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, array &$form_state) {

    // Check all entries.
    $node_types = node_type_get_names();
    foreach ($node_types as $type => $name) {
      if ( ((int)$form_state['values']['limit_' . $type]) <= 0 ) {
        $this->setFormError('limit_' . $type, $form_state, $this->t('You should enter a number upper to 0 for @type.', array('@type' => $type)));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {

    // Get config object.
    $config = \Drupal::config('nodelimit.settings');

    // Add configuration for each type.
    $node_types = node_type_get_names();
    foreach ($node_types as $type => $name) {
      $config->set('limit_' . $type, $form_state['values']['limit_' . $type]);
    }

    // Save configuration.
    $config->save();

    drupal_set_message($this->t('All limits are saved for each type.'));
  }
}
