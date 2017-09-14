<?php

/**
 * @file
 * Modify structured content arrays.
 *
 * These hooks are called after the content has been assembled in a structured
 * array and may be used for doing processing which requires that the complete
 * content structure has been built.
 *
 * If the theme wishes to act on the rendered HTML of the content rather than
 * the structured content array, it may use this hook to add a #post_render
 * callback. Alternatively, it could also implement hook_preprocess_HOOK().
 *
 * @see \Drupal\Core\Render\RendererInterface
 * @see \Drupal\Core\Render\Renderer
 */

use Drupal\uikit_components\UIkitComponents;

/**
 * Implements hook_theme_suggestions_HOOK_alter().
 */
function uikit_components_theme_suggestions_menu_alter(array &$suggestions, array $variables) {
  $menu_name = isset($variables['menu_name']) ? $variables['menu_name'] : FALSE;
  $config = \Drupal::config('uikit_components.settings');

  if ($menu_name && $config->get('additional_menu_styles')) {
    $menu_style = UIkitComponents::getMenuStyle($menu_name);

    if ($menu_style) {
      switch ($menu_style) {
        case 'uk-list':
        case 'uk-list-bullet':
        case 'uk-list-divider':
        case 'uk-list-striped':
        case 'uk-subnav':
        case 'uk-subnav-divider':
        case 'uk-subnav-pill':
          $suggestions[] = 'menu__uk_menu';
          break;

        case 'uk-nav':
          $suggestions[] = 'menu__uk_nav';
          break;
      }
    }
    elseif ($menu_name != 'admin' && $menu_name != 'devel') {
      $suggestions[] = 'menu__default';
    }
  }
}
