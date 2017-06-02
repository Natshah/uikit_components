<?php

namespace Drupal\uikit_components\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\uikit_components\UIkitComponents;

class UIkitComponentsAdminForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'uikit_components_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('uikit_components.settings');

    // Get UIkit framework version from UIkit base theme.
    $uikit_version = UIkitComponents::getUIkitLibraryVersion();
    if ($uikit_version) {
      $config->set('uikit_components.uikit_framework_version', $uikit_version);
    }
    else {
      $config->set('uikit_components.uikit_framework_version', $this->t('The UIkit base theme is not installed.'));
    }

    // UIkit framework version field.
    $form['uikit_framework_version'] = [
      '#type' => 'item',
      '#title' => $this->t('UIkit Framework Version'),
      '#markup' => $config->get('uikit_components.uikit_framework_version'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'uikit_components.settings',
    ];
  }

}