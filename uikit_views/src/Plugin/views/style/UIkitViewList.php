<?php

namespace Drupal\uikit_views\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render each item in a UIkit List component.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "uikit_view_list",
 *   title = @Translation("UIkit List"),
 *   help = @Translation("Displays rows in a UIkit List component"),
 *   theme = "uikit_view_list",
 *   display_types = {"normal"}
 * )
 */
class UIkitViewList extends StylePluginBase {

  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Does the style plugin support custom css class for the rows.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['type'] = ['default' => 'ul'];
    $options['class'] = ['default' => 'uk-list'];
    $options['wrapper_class'] = ['default' => 'uikit-view-list'];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $args = [
      '@href' => 'https://getuikit.com/v2/docs/list.html',
      '@title' => 'List component - UIkit documentation',
    ];

    $form['wrapper_class'] = [
      '#title' => $this->t('Wrapper class'),
      '#description' => $this->t('The class to provide on the wrapper, outside the list.'),
      '#type' => 'textfield',
      '#size' => '30',
      '#default_value' => $this->options['wrapper_class'],
    ];
    $form['class'] = [
      '#title' => $this->t('List class'),
      '#description' => $this->t('The modifier to apply to the list. See <a href="@href" target="_blank" title="@title">List component</a> to view examples of each list modifier.', $args),
      '#type' => 'select',
      '#default_value' => $this->options['class'],
      '#options' => [
        'default' => $this->t('Default'),
        'uk-list-line' => $this->t('List line'),
        'uk-list-striped' => $this->t('List striped'),
        'uk-list-space' => $this->t('List space'),
      ],
    ];
  }

}
