<?php

/**
 * @file
 * Set up variables to be placed within the template (.html.twig) files.
 *
 * The variables set up here apply to both templates (.html.twig) files and
 * functions (theme_HOOK). These are also used for providing
 * @link https://www.drupal.org/node/2354645 Twig Template naming conventions @endlink.
 *
 * @see process.inc
 */

use Drupal\Core\Template\Attribute;
use Drupal\uikit_components\UIkitComponents;

/**
 * Implements template_preprocess_HOOK() for menu--uk-list.html.twig.
 */
function template_preprocess_menu__uk_list(&$variables) {
  $menu_name = $variables['menu_name'];

  $menu_style = UIkitComponents::getMenuStyle($menu_name);
  $large_list = UIkitComponents::getLargeList($menu_name);
  $nav_width_classes = UIkitComponents::getNavWidthClasses($menu_name);

  $attributes = new Attribute();
  $wrapper_attributes = new Attribute();

  $attributes->addClass('uk-list');

  if ($menu_style && $menu_style != 'uk-list') {
    $attributes->addClass($menu_style);
  }

  if ($large_list) {
    $attributes->addClass('uk-list-large');
  }

  if ($nav_width_classes) {
    $classes = explode(' ', $nav_width_classes);

    foreach ($classes as $class) {
      $wrapper_attributes->addClass($class);
    }
  }

  $variables['attributes'] = $attributes;
  $variables['wrapper_attributes'] = $wrapper_attributes;
}

/**
 * Implements template_preprocess_HOOK() for menu--uk-nav.html.twig.
 */
function template_preprocess_menu__uk_nav(&$variables) {
  $menu_name = $variables['menu_name'];

  $menu_style = UIkitComponents::getMenuStyle($menu_name);
  $nav_style_modifier = UIkitComponents::getNavStyleModifier($menu_name);
  $nav_center = UIkitComponents::getNavCenterModifier($menu_name);
  $nav_width_classes = UIkitComponents::getNavWidthClasses($menu_name);

  $attributes = new Attribute();
  $wrapper_attributes = new Attribute();

  if ($menu_style) {
    $attributes->addClass('uk-nav');

    if ($nav_style_modifier) {
      $attributes->addClass($nav_style_modifier);
    }

    if ($nav_center) {
      $attributes->addClass('uk-nav-center');
    }

    foreach ($variables['items'] as $index => $item) {
      if ($item['below']) {
        $variables['items'][$index]['attributes']->addClass('uk-parent');
      }
    }
  }

  if ($nav_width_classes) {
    $classes = explode(' ', $nav_width_classes);

    foreach ($classes as $class) {
      $wrapper_attributes->addClass($class);
    }
  }

  $variables['attributes'] = $attributes;
  $variables['wrapper_attributes'] = $wrapper_attributes;
}

/**
 * Implements template_preprocess_HOOK() for menu--uk-subnav.html.twig.
 */
function template_preprocess_menu__uk_subnav(&$variables) {
  $menu_name = $variables['menu_name'];

  $menu_style = UIkitComponents::getMenuStyle($menu_name);
  $nav_width_classes = UIkitComponents::getNavWidthClasses($menu_name);

  $attributes = new Attribute();
  $wrapper_attributes = new Attribute();

  if ($menu_style) {
    $attributes->addClass('uk-subnav');

    if ($menu_style != 'uk-subnav') {
      $attributes->addClass($menu_style);
    }
  }

  if ($nav_width_classes) {
    $classes = explode(' ', $nav_width_classes);

    foreach ($classes as $class) {
      $wrapper_attributes->addClass($class);
    }
  }

  $variables['attributes'] = $attributes;
  $variables['wrapper_attributes'] = $wrapper_attributes;
}
