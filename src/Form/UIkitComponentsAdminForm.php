<?php

namespace Drupal\uikit_components\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
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
    // Translatable strings.
    $t_args = [
      ':uikit_project' => Url::fromUri('https://www.drupal.org/project/uikit')->toString(),
    ];

    // Get UIkit framework version from UIkit base theme.
    $uikit_version = UIkitComponents::getUIkitLibraryVersion();
    $framework_version = '';
    if ($uikit_version[0]) {
      $config->set('uikit_components.uikit_framework_version', $uikit_version[0]);
      $framework_version = 'disabled';
    }

    // UIkit framework version field.
    $form['uikit_framework_version'] = [
      '#type' => 'select',
      '#title' => $this->t('UIkit Framework'),
      '#default_value' => $config->get('uikit_components.uikit_framework_version'),
      '#description' => $this->t('Select the version of the UIkit framework your theme uses. This is important because the framework versions are not compatible with each other. If the UIkit base theme is found in your Drupal installation this value is selected for you. Otherwise you can download the base theme <a href=":uikit_project" target="_blank">here</a>.', $t_args),
      '#options' => [
        0 => $this->t('- Select -'),
        2 => $this->t('v2.x.x'),
        3 => $this->t('v3.x.x'),
      ],
      '#disabled' => $framework_version,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('uikit_components.settings');
    $config->set('uikit_components.uikit_framework_version', $form_state->getValue('uikit_framework_version'));
    $config->save();
    return parent::submitForm($form, $form_state);
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