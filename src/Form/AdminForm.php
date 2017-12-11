<?php

namespace Drupal\uikit_components\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\uikit_components\UIkitComponents;

/**
 * Form builder for the UIkit Components administration form.
 *
 * @package Drupal\uikit_components\Form
 */
class AdminForm extends ConfigFormBase {

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

    // UIkit framework version field.
    if ($uikit_version) {
      $form['uikit_framework_version'] = [
        '#type' => 'item',
        '#title' => $this->t('UIkit Framework Version'),
        '#markup' => $uikit_version ? $uikit_version : $this->t('The UIkit base theme is not installed.'),
      ];

      $form['additional_menu_styles'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Enable configurable menu styles'),
        '#description' => $this->t('Enable selecting menu styles when adding and editing <a href="/admin/structure/menu">menus</a>. This provides three new menu templates: <em class="placeholder">menu--default.html.twig</em> as a default, <em class="placeholder">menu--uk-menu.html.twig</em> for uk-list and uk-subnav menus and <em class="placeholder">menu--uk-nav.html.twig</em> for uk-nav menus. This also ignores the admin toolbar and devel module menus so they can be rendered correctly.'),
        '#default_value' => $config->get('additional_menu_styles'),
      ];
    }

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

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('uikit_components.settings');
    $config->set('additional_menu_styles', $form_state->getValue('additional_menu_styles'))->save();

    // For good measure, flush all cache.
    drupal_flush_all_caches();
  }

}