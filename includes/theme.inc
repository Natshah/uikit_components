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
    'uikit_breadcrumb' => [
      'render element' => 'element',
      'path' => "$path/components",
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
    'menu__uikit_list' => [
      'path' => "$path/navigation",
      'template' => 'menu--uikit-list',
    ],
    'menu__uikit_nav' => [
      'path' => "$path/navigation",
      'template' => 'menu--uikit-nav',
    ],
    'menu__uikit_subnav' => [
      'path' => "$path/navigation",
      'template' => 'menu--uikit-subnav',
    ],
  ];
}
