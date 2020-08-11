<?php

namespace Drupal\uikit_views\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\Component\Utility\Html;

/**
 * Style plugin to render each item in a UIkit Grid component.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "uikit_view_grid",
 *   title = @Translation("UIkit Grid"),
 *   help = @Translation("Displays rows in a UIkit Grid component"),
 *   theme = "uikit_view_grid",
 *   display_types = {"normal"}
 * )
 */
class UIkitViewGrid extends StylePluginBase {

  /**
   * {@inheritdoc}
   */
  protected $usesRowPlugin = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['width_'] = ['default' => 'uk-child-width-1-1'];
    $options['width_@s'] = ['default' => 'uk-child-width-1-1@s'];
    $options['width_@m'] = ['default' => 'uk-child-width-1-2@m'];
    $options['width_@l'] = ['default' => 'uk-child-width-1-3@l'];
    $options['width_@xl'] = ['default' => 'uk-child-width-1-4@xl'];
    $options['grid_divider'] = ['default' => TRUE];
    $options['grid_gutter'] = ['default' => 'default'];
    $options['grid_behavior'] = ['default' => NULL];
    $options['grid_match_height_selector'] = ['default' => NULL];
    $options['grid_lightbox'] = ['default' => NULL];
    $options['flex_classes'] = ['default' => NULL];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $args = [
      '@href' => 'https://getuikit.com/docs/grid',
      '@title' => 'Grid component - UIkit documentation',
    ];

    $breakpoints = [
      '' => $this->t('Affects all device widths'),
      '@s' => $this->t('Affects device widths of 640px and higher.'),
      '@m' => $this->t('Affects device widths of 960px and higher.'),
      '@l' => $this->t('Affects device widths of 1200px and higher.'),
      '@xl' => $this->t('Affects device widths of 1600px and higher.'),
    ];

    $form['grid_columns'] = [
      '#type' => 'item',
      '#title' => $this->t('Grid columns'),
      '#description' => $this->t("To create a grid whose child elements' widths are evenly split, we apply one class to the grid for each breakpoint. Each item in the grid is then automatically applied a width based on the number of columns selected for each breakpoint. See <a href='@href' target='_blank' title='@title'>Grid component</a> for more details.", $args),
    ];

    foreach (['', '@s', '@m', '@l', '@xl'] as $size) {
      $form["width_${size}"] = [
        '#type' => 'select',
        '#title' => $this->t("uk-child-width-*${size}"),
        '#required' => FALSE,
        '#default_value' => $this->options["width_${size}"],
        '#options' => [
          "uk-child-width-1-1${size}" => 1,
          "uk-child-width-1-2${size}" => 2,
          "uk-child-width-1-3${size}" => 3,
          "uk-child-width-1-4${size}" => 4,
          "uk-child-width-1-5${size}" => 5,
          "uk-child-width-1-6${size}" => 6,
        ],
        '#description' => $breakpoints[$size],
      ];
    }

    $form['grid_divider'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Grid divider'),
      '#default_value' => $this->options['grid_divider'],
      '#description' => $this->t('Apply a horizontal border to each row in the grid, except the first row.'),
    ];

    $form['grid_gutter'] = [
      '#type' => 'select',
      '#title' => $this->t('Grid gutter'),
      '#required' => TRUE,
      '#default_value' => $this->options['grid_gutter'],
      '#options' => [
        'default' => $this->t('Default gutter'),
        'uk-grid-small' => $this->t('Small gutter'),
        'uk-grid-medium' => $this->t('Medium gutter'),
        'uk-grid-large' => $this->t('Large gutter'),
        'uk-grid-collapse' => $this->t('Collapse gutter'),
      ],
      '#description' => $this->t('Grids automatically create a horizontal gutter between columns and a vertical one between two succeeding grids. By default, the grid gutter is wider on large screens.<br /><strong>Note</strong>: <em class="placeholder">Grid collapse</em> removes the grid gutter.'),
    ];

    $form['grid_behavior'] = [
      '#type' => 'select',
      '#title' => $this->t('Grid behavior'),
      '#default_value' => $this->options['grid_behavior'],
      '#empty_option' => $this->t('- None -'),
      '#options' => [
        'match' => $this->t('Match height'),
        'masonry' => $this->t('Masonry'),
      ],
      '#description' => $this->t('With "match height" setting, the direct child of each cell will have the same height.<br />With masonry setting, if grid cells have different heights, you obtain a layout free of gaps.'),
    ];

    $form['grid_match_height_selector'] = [
      '#title' => $this->t('The selector for match height (optional'),
      '#type' => 'textfield',
      '#default_value' => $this->options['grid_match_height_selector'],
      '#description' => $this->t('With "match height" setting, the direct child of each cell will have the same height.<br />If you want apply match height to another selector, use this field.'),
    ];

    $form['grid_lightbox'] = [
      '#title' => $this->t('Grid with lightbox'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['grid_lightbox'],
      '#description' => $this->t('If you have image field with lightbox formatter in your grid, you have to check this box.'),
    ];

    $form['flex_classes'] = [
      '#title' => $this->t('Extra classes, especially for flex behavior'),
      '#type' => 'textfield',
      '#default_value' => $this->options['flex_classes'],
      '#description' => $this->t('List of classes, delimited with space'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCustomClass($result_index, $type) {
    if (isset($this->options[$type . '_class_custom'])) {
      $class = $this->options[$type . '_class_custom'];
      if ($this->usesFields() && $this->view->field) {
        $class = strip_tags($this->tokenizeValue($class, $result_index));
      }

      $classes = explode(' ', $class);
      foreach ($classes as &$class) {
        $class = Html::cleanCssIdentifier($class);
      }
      return implode(' ', $classes);
    }
  }

}
