<?php

/**
 * @file
 * The UIkit Components theme system.
 *
 * The theme system allows for nearly all output of the Drupal system to be
 * customized.
 */

/**
 * Implements hook_theme().
 */
function uikit_components_theme($existing, $type, $theme, $path) {
  $path = drupal_get_path('module', 'uikit_components') . '/templates';

  return [
    // UIkit framework component theme implementations.
    'uikit_accordion' => [
      'render element' => 'element',
      'path' => "$path/components",
    ],
    'uikit_article' => [
      'render element' => 'element',
      'path' => "$path/components",
    ],
    'uikit_badge' => [
      'render element' => 'element',
      'path' => "$path/components",
    ],
    'uikit_card' => [
      'render element' => 'element',
      'path' => "$path/components",
    ],
    'uk_breadcrumb' => [
      'variables' => [
        'items' => NULL,
      ],
      'path' => "$path/navigation",
    ],
    'uk_countdown' => [
      'variables' => [
        'expire_date' => NULL,
        'separators' => NULL,
        'labels' => NULL,
      ],
      'path' => "$path/dataset",
    ],

    // Theme implementations which extend an existing core theme implementation.
    'menu__uk_list' => [
      'path' => "$path/navigation",
      'template' => 'menu--uk-list',
    ],
    'menu__uk_nav' => [
      'path' => "$path/navigation",
      'template' => 'menu--uk-nav',
    ],
    'menu__uk_subnav' => [
      'path' => "$path/navigation",
      'template' => 'menu--uk-subnav',
    ],
  ];
}
