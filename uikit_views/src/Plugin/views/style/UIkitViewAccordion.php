<?php

namespace Drupal\uikit_views\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render each item in a UIkit Accordion component.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "uikit_view_accordion",
 *   title = @Translation("UIkit Accordion"),
 *   help = @Translation("Displays rows in a UIkit Accordion component"),
 *   theme = "uikit_view_accordion",
 *   display_types = {"normal"}
 * )
 */
class UIkitViewAccordion extends StylePluginBase {

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
    $options['targets'] = ['default' => '> *'];
    $options['active'] = ['default' => 0];
    $options['collapsible'] = ['default' => TRUE];
    $options['multiple'] = ['default' => FALSE];
    $options['animation'] = ['default' => TRUE];
    $options['transition'] = ['default' => 'ease'];
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
        '#description' => $this->t('Select the field to use as the accordian title to create a toggle for the accordion items.'),
      ];
      $form['accordion_options'] = [
        '#type' => 'details',
        '#title' => $this->t('Accordion options'),
        '#open' => TRUE,
      ];
      $form['targets'] = [
        '#type' => 'textfield',
        '#title' => $this->t('CSS selector of the element(s) to toggle.'),
        '#default_value' => $this->options['targets'],
        '#fieldset' => 'accordion_options',
      ];
      $form['active'] = [
        '#type' => 'number',
        '#title' => $this->t('Index of the element to open initially.'),
        '#default_value' => $this->options['active'],
        '#fieldset' => 'accordion_options',
      ];
      $form['collapsible'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Allow all items to be closed.'),
        '#default_value' => $this->options['collapsible'],
        '#fieldset' => 'accordion_options',
      ];
      $form['multiple'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Allow multiple open items.'),
        '#default_value' => $this->options['multiple'],
        '#fieldset' => 'accordion_options',
      ];
      $form['animation'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Reveal item directly (unchecked) or with a transition (checked).'),
        '#default_value' => $this->options['animation'],
        '#fieldset' => 'accordion_options',
      ];
      $form['transition'] = [
        '#type' => 'select',
        '#title' => $this->t('Css selector for toggles'),
        '#default_value' => $this->options['transition'],
        '#description' => $this->t('Uses a keyword from <a href="@transition" target="_blank">easing functions</a>.', array('@transition' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/single-transition-timing-function#Keywords_for_common_timing-functions')),
        '#options' => array(
          'linear' => 'linear',
          'ease' => 'ease',
          'ease-in' => 'ease-in',
          'ease-in-out' => 'ease-in-out',
          'ease-out' => 'ease-out',
          'step-start' => 'step-start',
          'step-end' => 'step-end',
        ),
        '#fieldset' => 'accordion_options',
        '#required' => TRUE,
      ];
      $form['duration'] = [
        '#type' => 'number',
        '#title' => $this->t('Animation duration in milliseconds.'),
        '#default_value' => $this->options['duration'],
        '#fieldset' => 'accordion_options',
        '#required' => TRUE,
      ];
    }
  }

}
