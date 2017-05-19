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
  $variables['id'] = UIkitComponents::getUniqueId($view);
  $variables['attributes']['class'][] = 'grid';
  $options = $view->style_plugin->options;

  foreach (['small', 'medium', 'large', 'xlarge'] as $size) {
    $variables["width_" . $size] = $options["width_" . $size];
  }
  $variables['options'] = $options;
}
