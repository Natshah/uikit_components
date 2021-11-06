<?php

namespace Drupal\uikit_views\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render each item in a UIkit Switcher component.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "uikit_view_switcher",
 *   title = @Translation("UIkit Switcher"),
 *   help = @Translation("Displays rows in a UIkit Switcher component"),
 *   theme = "uikit_view_switcher",
 *   display_types = {"normal"}
 * )
 */
class UIkitViewSwitcher extends StylePluginBase {

  /**
   * Does the style plugin for itself support to add fields to it's output.
   *
   * @var bool
   */
  protected $usesFields = TRUE;

  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['title_field'] = ['default' => NULL];
    $options['targets'] = ['default' => '.uk-switcher'];
    $options['animation'] = ['default' => 'FALSE'];
    $options['duration'] = ['default' => 200];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    if (isset($form['grouping'])) {
      unset($form['grouping']);

      $form['title_field'] = [
        '#type' => 'select',
        '#title' => $this->t('Title field'),
        '#options' => $this->displayHandler->getFieldLabels(TRUE),
        '#required' => TRUE,
        '#default_value' => $this->options['title_field'],
        '#description' => $this->t('Select the field to use as the accordian title to create a toggle for the switcher items.'),
      ];
      $form['switcher_options'] = [
        '#type' => 'details',
        '#title' => $this->t('Switcher options'),
        '#open' => TRUE,
      ];
      $form['targets'] = [
        '#type' => 'textfield',
        '#title' => $this->t('CSS selector of the element(s) to toggle.'),
        '#default_value' => $this->options['targets'],
        '#fieldset' => 'switcher_options',
      ];
      $form['animation'] = [
        '#type' => 'select',
        '#title' => $this->t('Animation effect'),
        '#default_value' => $this->options['animation'],
        '#empty_option' => $this->t('-None-'),
        '#options' => [
          'uk-animation-fade' => $this->t('fade'),
          'uk-animation-scale-up' => $this->t('scale up'),
          'uk-animation-scale-down' => $this->t('scale down'),
          'uk-animation-slide-top' => $this->t('slide top'),
          'uk-animation-slide-bottom' => $this->t('slide down'),
          'uk-animation-slide-left' => $this->t('slide left'),
          'uk-animation-slide-right' => $this->t('slide right'),
          'uk-animation-slide-top-small' => $this->t('slide top small'),
          'uk-animation-slide-bottom-small' => $this->t('slide bottom small'),
          'uk-animation-slide-left-small' => $this->t('slide left small'),
          'uk-animation-slide-right-small' => $this->t('slide right small'),
          'uk-animation-slide-top-medium' => $this->t('slide top medium'),
          'uk-animation-slide-bottom-medium' => $this->t('slide bottom medium'),
          'uk-animation-slide-left-medium' => $this->t('slide left medium'),
          'uk-animation-slide-right-medium' => $this->t('slide right medium'),
          'uk-animation-shake' => $this->t('shake'),
        ],
        '#fieldset' => 'switcher_options',
        '#required' => FALSE,
      ];
      $form['duration'] = [
        '#type' => 'number',
        '#title' => $this->t('Animation duration in milliseconds.'),
        '#default_value' => $this->options['duration'],
        '#fieldset' => 'switcher_options',
        '#required' => TRUE,
      ];
    }
  }

}
