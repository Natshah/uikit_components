<?php

/**
 * @file
 * Preprocessors and helper functions to make theming easier.
 */

use Drupal\Core\Template\Attribute;
use Drupal\uikit_views\UIkitViews;

/**
 * Prepares variables for UIkit Accordion templates.
 *
 * Default template: uikit-view-accordion.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_accordion(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;
  $title_field = $options['title_field'];
  $accordion_data = [];
  $items = [];

  if ($title_field) {
    foreach ($variables['rows'] as $result_index => $item) {
      $title = $view->style_plugin->getFieldValue($result_index, $title_field);
      $items[$result_index]['content'] = $item;
      $items[$result_index]['title'] = $title;
    }
  }

  // Set items array for twig template.
  $variables['items'] = $items;

  // Create attributes for accordion.
  $accordion_data[] = 'targets: ' . ($options['targets'] ? $options['targets'] : '> *');
  $accordion_data[] = 'active: ' . ($options['active'] ? $options['active'] : 'false');
  $accordion_data[] = 'collapsible: ' . ($options['collapsible'] ? 'true' : 'false');
  $accordion_data[] = 'multiple: ' . ($options['multiple'] ? 'true' : 'false');
  $accordion_data[] = 'animation: ' . ($options['animation'] ? 'true' : 'false');
  $accordion_data[] = 'transition: ' . $options['transition'];
  $accordion_data[] = 'duration: ' . $options['duration'];
  $data_accordion = implode('; ', $accordion_data);

  $accordion_attributes = new Attribute();
  $accordion_attributes->addClass('uk-accordion');
  $accordion_attributes->setAttribute('uk-accordion', $data_accordion);

  // Set accordion attributes for twig template.
  $variables['accordion_attributes'] = $accordion_attributes;
}

/**
 * Prepares variables for UIkit Grid templates.
 *
 * Default template: uikit-view-grid.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_grid(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;
  $grid_classes = ['uk-grid'];

  if ($options['grid_gutter'] != 'default') {
    $grid_classes[] = $options['grid_gutter'];
  }

  foreach (['@s', '@m', '@l', '@xl'] as $size) {
    $grid_classes[] = $options["width_" . $size];
  }

  $variables['grid_classes'] = implode(' ', $grid_classes);

  $variables['id'] = UIkitViews::getUniqueId($view);
  $variables['options'] = $options;

  $items = [];

  // Iterate over each rendered views result row.
  foreach ($variables['rows'] as $result_index => $item) {
    $items[$result_index]['content'] = $item;
  }

  // Add items to the variables array.
  $variables['items'] = $items;
}

/**
 * Prepares variables for UIkit List templates.
 *
 * Default template: uikit-view-list.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_list(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;

  // Set the wrapper attributes.
  $variables['attributes'] = new Attribute();
  if ($options['wrapper_class']) {
    $variables['attributes']->addClass($options['wrapper_class']);
  }

  // Set the list attributes.
  $variables['list_attributes'] = new Attribute();
  $variables['list_attributes']['class'] = ['uk-list'];

  if ($options['class'] != 'default') {
    $variables['list_attributes']['class'][] = $options['class'];
  }

  $items = [];

  // Iterate over each rendered views result row.
  foreach ($variables['rows'] as $result_index => $item) {
    $items[$result_index]['content'] = $item;
  }

  // Add items to the variables array.
  $variables['items'] = $items;
}

/**
 * Prepares variables for UIkit Table templates.
 *
 * Default template: uikit-view-table.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_table(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;

  // Add additional options as variables.
  $variables['responsive_table'] = $options['responsive_table'];
  $variables['vertical_modifier'] = $options['vertical_modifier'];

  // Add each table modifier option as variables.
  $table_modifiers = $options['table_modifiers'];
  foreach ($table_modifiers as $modifier_key => $modifier) {
    $variables[$modifier_key] = $modifier;
  }
}
