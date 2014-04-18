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
    
    $form['details_form'] = array(
      '#type' => 'details',
      '#title' => $this->t('Create Form'),
      '#open' => FALSE,
    );
    $form['details_form']['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Task Title'),
      '#description' => $this->t('Enter the title of the task.')
    );
    
    $form['details_form']['description'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Task Description'),
      '#description' => $this->t('Enter the description of the task.')
    );
    
    $form['details_form']['actions'] = array(
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
    
    // Get values.
    $title = $form_state['values']['title'];
    $content = $form_state['values']['description'];
    
    $task = \Drupal::entityManager()->getStorage('node')->create(array(
    	'type' => 'task',
      'title' => $title,
      'body' => $content,
    ));
    $task->save();
    
    drupal_set_message($this->t('The task @task has been saved', array('@task' => $title)));
  }

  
}
