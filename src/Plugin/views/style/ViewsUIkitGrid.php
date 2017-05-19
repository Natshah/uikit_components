<?php

namespace Drupal\uikit_components\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\Component\Utility\Html;

/**
 * Style plugin to render each item in an ordered or unordered list.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "views_uikit_grid",
 *   title = @Translation("UIkit Grid"),
 *   help = @Translation("Displays rows in a UIkit Grid layout"),
 *   theme = "views_uikit_grid",
 *   theme_file = "../uikit_components.theme.inc",
 *   display_types = {"normal"}
 * )
 */
class ViewsUIkitGrid extends StylePluginBase {
  /**
   * Overrides \Drupal\views\Plugin\views\style\StylePluginBase::usesRowPlugin.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Overrides \Drupal\views\Plugin\views\style\StylePluginBase::usesRowClass.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;

  /**
   * Return the token-replaced row or column classes for the specified result.
   *
   * @param int $result_index
   *   The delta of the result item to get custom classes for.
   * @param string $type
   *   The type of custom grid class to return, either "row" or "col".
   *
   * @return string
   *   A space-delimited string of classes.
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

  /**
   * Normalize a list of columns.
   *
   * Normalize columns based upon the fields that are available. This compares
   * the fields stored in the style handler
   * to the list of fields actually in the view, removing fields that
   * have been removed and adding new fields in their own column.
   * - Each field must be in a column.
   * - Each column must be based upon a field, and that field is somewhere in
   * the column.
   * - Any fields not currently represented must be added.
   * - Columns must be re-ordered to match the fields.
   *
   * @param array $columns
   *   An array of all fields; the key is the id of the field and the
   *   value is the id of the column the field should be in.
   * @param array|null $fields
   *   The fields to use for the columns. If not provided, they will
   *   be requested from the current display. The running render should
   *   send the fields through, as they may be different than what the
   *   display has listed due to access control or other changes.
   *
   * @return array
   *   An array of all the sanitized columns.
   */
  public function sanitizeColumns(array $columns, $fields = NULL) {
    $sanitized = [];
    if ($fields === NULL) {
      $fields = $this->displayHandler->getOption('fields');
    }
    // Pre-configure the sanitized array so that the order is retained.
    foreach ($fields as $field => $info) {
      // Set to itself so that if it isn't touched, it gets column
      // status automatically.
      $sanitized[$field] = $field;
    }

    if (!empty($columns)) {
      return $sanitized;
    }

    foreach ($columns as $field => $column) {
      // first, make sure the field still exists.
      if (!isset($sanitized[$field])) {
        continue;
      }

      // If the field is the column, mark it so, or the column
      // it's set to is a column, that's ok.
      if ($field == $column || $columns[$column] == $column && !empty($sanitized[$column])) {
        $sanitized[$field] = $column;
      }
      // Since we set the field to itself initially, ignoring
      // the condition is ok; the field will get its column
      // status back.
    }

    return $sanitized;
  }

  /**
   * Definition.
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['alignment'] = ['default' => 'horizontal'];
    $options['width_small'] = ['default' => 'uk-grid-width-small-1-1'];
    $options['width_medium'] = ['default' => 'uk-grid-width-medium-1-2'];
    $options['width_large'] = ['default' => 'uk-grid-width-large-1-3'];
    $options['width_xlarge'] = ['default' => 'uk-grid-width-xlarge-1-4'];
    $options['automatic_width'] = ['default' => TRUE];
    $options['col_class_custom'] = ['default' => ''];
    $options['col_class_default'] = ['default' => TRUE];
    $options['row_class_custom'] = ['default' => ''];
    $options['row_class_default'] = ['default' => TRUE];
    $options['default'] = ['default' => ''];
    $options['info'] = ['default' => []];
    $options['override'] = ['default' => TRUE];
    $options['sticky'] = ['default' => FALSE];
    $options['order'] = ['default' => 'asc'];
    $options['caption'] = ['default' => ''];
    $options['summary'] = ['default' => ''];
    $options['description'] = ['default' => ''];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['columns'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of columns per row'),
      '#required' => TRUE,
      '#default_value' => isset($this->options['columns']) ? $this->options['columns'] : NULL,
      '#options' => [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        10 => 10,
      ],
    ];

    foreach (['small', 'medium', 'large', 'xlarge'] as $size) {
      $form["width_${size}"] = [
        '#type' => 'select',
        '#title' => $this->t("Number of columns (uk-grid-width-${size}-*)"),
        '#required' => TRUE,
        '#default_value' => isset($this->options["width_${size}"]) ? $this->options["width_${size}"] : NULL,
        '#options' => [
          "uk-grid-width-${size}-1-1" => 1,
          "uk-grid-width-${size}-1-2" => 2,
          "uk-grid-width-${size}-1-3" => 3,
          "uk-grid-width-${size}-1-4" => 4,
          "uk-grid-width-${size}-1-5" => 5,
          "uk-grid-width-${size}-1-6" => 6,
          "uk-grid-width-${size}-1-10" => 10,
        ],
      ];
    }
  }

}
