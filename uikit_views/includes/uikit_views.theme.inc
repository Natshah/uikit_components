<?php

/**
 * @file
 * Preprocessors and helper functions to make theming easier.
 */

use Drupal\Core\Template\Attribute;
use Drupal\uikit_components\UIkitComponents;
use Drupal\uikit_views\UIkitViews;

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

  $variables['grid_divider'] = FALSE;
  if ($options['grid_divider']) {
    $variables['grid_divider'] = TRUE;
  }

  if ($options['grid_gutter'] != 'default') {
    $grid_classes[] = $options['grid_gutter'];
  }

  foreach (['small', 'medium', 'large', 'xlarge'] as $size) {
    $grid_classes[] = $options["width_" . $size];
  }

  if ($options['row_class']) {
    $grid_classes[] = $options['row_class'];
  }

  $variables['grid_classes'] = implode(' ', $grid_classes);

  $variables['id'] = UIkitViews::getUniqueId($view);
  $variables['options'] = $options;
  $variables['uikit_version'] = UIkitComponents::getUIkitLibraryVersion();
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
  $variables['list_attributes'] = new Attribute();
  $variables['list_attributes']['class'] = ['uk-list'];

  if ($options['class'] != 'default') {
    $variables['list_attributes']['class'][] = $options['class'];
  }
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
