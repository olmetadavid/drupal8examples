<?php

namespace Drupal\tasks\Form;

use Drupal\Core\Form\FormBase;

/**
 * Description of CreateForm
 *
 * @author david
 */
class CreateTaskForm extends FormBase {
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    
    $form['fieldset_form'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Create Form'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );
    $form['fieldset_form']['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Task Title'),
      '#description' => $this->t('Enter the title of the task.')
    );
    
    $form['fieldset_form']['description'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Task Description'),
      '#description' => $this->t('Enter the description of the task.')
    );
    
    $form['fieldset_form']['actions'] = array(
      '#type' => 'actions',
      'submit' => array(
        '#type' => 'submit',
        '#value' => $this->t('Create'),
      )
    );
    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return "tasks_create_form";
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    
  }

  
}
