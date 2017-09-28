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
    'uk_accordion' => [
      'variables' => [
        'items' => NULL,
      ],
      'path' => "$path/dataset",
    ],
    'uk_article' => [
      'variables' => [
        'title' => NULL,
        'meta' => NULL,
        'lead' => NULL,
        'content' => NULL,
      ],
      'path' => "$path/dataset",
    ],
    'uk_badge' => [
      'variables' => [
        'items' => NULL,
      ],
      'path' => "$path/dataset",
    ],
    'uk_breadcrumb' => [
      'variables' => [
        'items' => NULL,
      ],
      'path' => "$path/navigation",
    ],
    'uk_card' => [
      'variables' => [
        'title' => NULL,
        'content' => NULL,
        'modifiers' => [
          'style' => 'default',
          'hover' => FALSE,
          'size' => NULL,
        ],
        'header' => NULL,
        'footer' => NULL,
      ],
      'path' => "$path/dataset",
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
