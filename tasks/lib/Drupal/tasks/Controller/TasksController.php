<?php

namespace Drupal\tasks\Controller;

use \Drupal\Core\Controller\ControllerBase;

/**
 * Description of TasksController
 *
 * @author david
 */
class TasksController extends ControllerBase {
  
  /**
   * Display the task list.
   */
  public function displayList() {
    $content = array ();
    
    $content ['summary_form'] = array (
        '#type' => 'markup',
        '#markup' => $this->t ( 'Create new task' ) 
    );
    
    // Get and add the form.
    $content ['page_form'] = \Drupal::formBuilder ()->getForm ( '\Drupal\tasks\Form\CreateTaskForm' );
    
    $content ['summary_list'] = array (
        '#type' => 'markup',
        '#markup' => $this->t ( 'List of all tasks' ) 
    );
    
    // Get all tasks.
    $nodes = \Drupal::entityManager ()->getStorage ( 'node' )->loadByProperties ( array (
        'type' => 'task' 
    ) );
    
    // Display the list, or empty text if no tasks have been found.
    if (empty ( $nodes )) {
      $content ['task_nodata'] = array (
          '#type' => 'container',
          'data' => array (
              '#type' => 'markup',
              '#markup' => $this->t ( 'There is no tasks found.' ) 
          ) 
      );
    }
    else {
      foreach ( $nodes as $node ) {
        $content ['task_' . $node->id ()] = array (
            '#type' => 'container',
            'data' => array (
                '#type' => 'markup',
                '#markup' => $node->getTitle () 
            ) 
        );
      }
    }
    
    return $content;
  }
}
