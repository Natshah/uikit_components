<?php

/**
 * @file
 * The UIkit Components theme system.
 *
 * The theme system allows for nearly all output of the Drupal system to be
 * customized.
 */

use Drupal\uikit_components\UIkitComponents;

/**
 * Implements hook_theme().
 */
function uikit_components_theme($existing, $type, $theme, $path) {
  $path = drupal_get_path('module', 'uikit_components') . '/templates';
  $components = UIkitComponents::getRenderElementList();
  $items = [];

  foreach ($components as $component) {
    // UIkit components render elements.
    $items["uikit_$component"] = [
      'render element' => 'element',
      'path' => "$path/components",
    ];
  }

  // Theme implementations which extend an existing core theme implementation.
  $items['menu__uikit_list'] = [
    'path' => "$path/navigation",
    'template' => 'menu--uikit-list',
  ];
  $items['menu__uikit_nav'] = [
    'path' => "$path/navigation",
    'template' => 'menu--uikit-nav',
  ];
  $items['menu__uikit_subnav'] = [
    'path' => "$path/navigation",
    'template' => 'menu--uikit-subnav',
  ];

  return $items;
}
