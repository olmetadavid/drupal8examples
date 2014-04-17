<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 17/04/2014
 * Time: 07:59
 */

namespace Drupal\userinfos\Plugin\Block;

use Drupal\block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Class UserInfosBlock
 *
 * Provides a block which display some informations about the current user.
 * @package Drupal\userinfos\Plugin\Block
 * @Block(
 *  id = "userinfos_display",
 *  admin_label = @Translation("Display current user infos"),
 *  category = @Translation("User")
 * )
 */
class UserInfosBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $content = array();

    $content['text'] = array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello,'),
    );
    
    // Get user fields.
    $fields = \Drupal\field\Field::fieldInfo()->getInstances('user', 'user');

    // Get current user.
    $account = \Drupal::currentUser();
    $user = user_load($account->id());
    
    // The array contains all fields keyed by bundlename, so reuse it.
    foreach ($fields['user'] as $field_key => $field) {
      if ($this->configuration['fields'][$field_key]) {
        $content['info_' . $field_key] = array(
          '#type' => 'container',
          'data' => array(
            '#type' => 'markup',
            '#markup' => $field->getLabel() . ': ' . $user->get($field_key)->value,
          ),
        );
      }
    }
    
    return $content;
  }

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account) {
    return $account->hasPermission('access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, &$form_state) {

    // Get user fields.
    $fields = \Drupal\field\Field::fieldInfo()->getInstances('user', 'user');

    // The array contains all fields keyed by bundlename, so reuse it.
    foreach ($fields['user'] as $field_key => $field) {
      $form['field_' . $field_key] = array(
        '#type' => 'checkbox',
        '#title' => $this->t('Field @field', array('@field' => $field->getLabel())),
        '#description' => $this->t('Display this field in the block.'),
        '#default_value' => $this->configuration['fields'][$field_key],
      );
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, &$form_state) {

    // Get user fields.
    $fields = \Drupal\field\Field::fieldInfo()->getInstances('user', 'user');

    // The array contains all fields keyed by bundlename, so reuse it.
    foreach ($fields['user'] as $field_key => $field) {
      $this->configuration['fields'][$field_key] = $form_state['values']['field_' . $field_key];
    }
  }

  /**
   * {@inheritdoc)
   */
  public function defaultConfiguration() {
    return array(
      'fields' => array(),
    );
  }
}