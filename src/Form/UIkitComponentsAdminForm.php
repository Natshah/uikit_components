<?php

namespace Drupal\uikit_components\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

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

    // To-do field.
    $form['todo'] = array(
      '#markup' => t('<em>@TODO: Replace example form with configuration settings.</em>'),
    );
    // Page title field.
    $form['page_title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Lorem ipsum generator page title:'),
      '#default_value' => $config->get('uikit_components.page_title'),
      '#description' => $this->t('Give your lorem ipsum generator page a title.'),
    );
    // Source text field.
    $form['source_text'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Source text for lorem ipsum generation:'),
      '#default_value' => $config->get('uikit_components.source_text'),
      '#description' => $this->t('Write one sentence per line. Those sentences will be used to generate random text.'),
    );

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
    $config->set('uikit_components.source_text', $form_state->getValue('source_text'));
    $config->set('uikit_components.page_title', $form_state->getValue('page_title'));
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