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
 * Implements template_preprocess_HOOK().
 */
function template_preprocess_menu__default(&$variables) {
  $menu_name = $variables['menu_name'];
  $nav_width_classes = UIkitComponents::getNavWidthClasses($menu_name);
  $variables['wrapper_attributes'] = FALSE;

  if ($nav_width_classes) {
    $wrapper_attributes = new Attribute();
    $classes = explode(' ', $nav_width_classes);

    foreach ($classes as $class) {
      $wrapper_attributes->addClass($class);
    }

    $variables['wrapper_attributes'] = $wrapper_attributes;
  }
}

/**
 * Implements template_preprocess_HOOK().
 */
function template_preprocess_menu__uk_menu(&$variables) {
  $menu_name = $variables['menu_name'];
  $menu_style = UIkitComponents::getMenuStyle($menu_name);
  $large_list = UIkitComponents::getLargeList($menu_name);

  if ($menu_style) {
    $attributes = new Attribute();

    switch ($menu_style) {
      case 'uk-list':
      case 'uk-list-bullet':
      case 'uk-list-divider':
      case 'uk-list-striped':
        $attributes->addClass('uk-list');
        break;

      case 'uk-nav':
        $attributes->addClass('uk-nav');
        break;

      case 'uk-subnav':
      case 'uk-subnav-divider':
      case 'uk-subnav-pill':
        $attributes->addClass('uk-subnav');
        break;
    }

    if ($menu_style != 'uk-list' && $menu_style != 'uk-nav' && $menu_style != 'uk-subnav') {
      $attributes->addClass($menu_style);
    }
    elseif ($menu_style == 'uk-nav') {
      $nav_accordion = UIkitComponents::getNavAccordion($menu_name);
      $nav_style_modifier = UIkitComponents::getNavStyleModifier($menu_name);
      $nav_center = UIkitComponents::getNavCenterModifier($menu_name);

      if ($nav_accordion) {
        $attributes->addClass('uk-nav-parent-icon');
        $attributes->setAttribute('uk-nav', '');
      }

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

    if ($large_list) {
      $attributes->addClass('uk-list-large');
    }

    $variables['attributes'] = $attributes;
  }

  $nav_width_classes = UIkitComponents::getNavWidthClasses($menu_name);
  $variables['wrapper_attributes'] = FALSE;

  if ($nav_width_classes) {
    $wrapper_attributes = new Attribute();
    $classes = explode(' ', $nav_width_classes);

    foreach ($classes as $class) {
      $wrapper_attributes->addClass($class);
    }

    $variables['wrapper_attributes'] = $wrapper_attributes;
  }
}

/**
 * Implements template_preprocess_HOOK().
 */
function template_preprocess_menu__uk_nav(&$variables) {
  $menu_name = $variables['menu_name'];
  $menu_style = UIkitComponents::getMenuStyle($menu_name);

  if ($menu_style) {
    $attributes = new Attribute();
    $attributes->addClass('uk-nav');

    $nav_style_modifier = UIkitComponents::getNavStyleModifier($menu_name);
    $nav_center = UIkitComponents::getNavCenterModifier($menu_name);

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

    $variables['attributes'] = $attributes;
  }

  $nav_width_classes = UIkitComponents::getNavWidthClasses($menu_name);
  $variables['wrapper_attributes'] = FALSE;

  if ($nav_width_classes) {
    $wrapper_attributes = new Attribute();
    $classes = explode(' ', $nav_width_classes);

    foreach ($classes as $class) {
      $wrapper_attributes->addClass($class);
    }

    $variables['wrapper_attributes'] = $wrapper_attributes;
  }
}
