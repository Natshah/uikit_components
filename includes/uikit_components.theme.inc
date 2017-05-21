<?php

/**
 * @file
 * Preprocessors and helper functions to make theming easier.
 */

use Drupal\uikit_components\UIkitComponents;

/**
 * Prepares variables for views grid templates.
 *
 * Default template: views-uikit-grid.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_views_uikit_grid(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;
  $grid_classes = ['uk-grid'];

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

  $variables['id'] = UIkitComponents::getUniqueId($view);
  $variables['options'] = $options;
  $variables['uikit_version'] = UIkitComponents::getUIkitLibraryVersion();
}
