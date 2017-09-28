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
 * Prepares variables for UIkit Accordion templates.
 *
 * Default template: uk-accordion.html.twig.
 *
 * @param $variables
 *   An associative array containing:
 *   - items: An array of items to be displayed in the accordion. Each item must
 *     contain the #title and #content properties. The #title property can only
 *     be a string, whereas the #content property can contain any valid HTML.
 */
function template_preprocess_uk_accordion(&$variables) {
  $attributes = new Attribute();
  $attributes->addClass('uk-accordion');
  $attributes->setAttribute('uk-accordion', '');
  $variables['attributes'] = $attributes;
}

/**
 * Prrpares variables for UIkit Article templates.
 *
 * Default template: uk-article.html.twig.
 *
 * @param $variables:
 *   An associative array containing:
  *   - title (optional): The title of the article.
  *   - meta (optional): The metadata of the article, such as the author and
  *     created date.
  *   - lead (optional): The leading paragraph of the article.
  *   - content: The content of the article.
 */
function template_preprocess_uk_article(&$variables) {
  $attributes = new Attribute();
  $attributes->addClass('uk-article');
  $variables['attributes'] = $attributes;
}

/**
 * Prrpares variables for UIkit Badge templates.
 *
 * Default template: uk-badge.html.twig.
 *
 * @param $variables:
 *   An associative array containing:
 *   - content: The content of the article.
 */
function template_preprocess_uk_badge(&$variables) {
  $attributes = new Attribute();
  $attributes->addClass('uk-badge');
  $variables['attributes'] = $attributes;
}

/**
 * Prepares variables for UIkit Breadcrumb templates.
 *
 * Default template: uk-breadcrumb.html.twig.
 *
 * @param $variables
 *   An associative array containing:
 *   - items: An array of items to be displayed in the breadcrumb. Each item
 *     must contain the #text property and can optionally contain the #url
 *     property to display the item as a link.
 */
function template_preprocess_uk_breadcrumb(&$variables) {
  $attributes = new Attribute();
  $attributes->addClass('uk-breadcrumb');
  $variables['attributes'] = $attributes;

  foreach ($variables['items'] as $key => $item) {
    $item_attributes = new Attribute();

    if (isset($item['disabled']) && $item['disabled']) {
      $item_attributes->addClass('uk-disabled');
    }

    $variables['items'][$key]['attributes'] = $item_attributes;
  }
}

/**
 * Prepares variables for UIkit Card templates.
 *
 * Default template: uk-card.html.twig.
 *
 * @param $variables
 *   An associative array containing:
 *   - title (optional): The title to display in the card.
 *   - content: The content of the card.
 *   - modifiers: An associative array of UIkit card modifiers containing:
 *     - style (optional): Adds a specific style to cards. Can be one of
 *       following:
 *       - default (Default): Creates a visually styled box.
 *       - primary: Emphasize the card with a primary color.
 *       - secondary: Gives the card a secondary background color.
 *     - hover (optional): Set to TRUE to create a hover effect on the card.
 *     - size (optional): Applies different size modifiers to cards that will
 *       decrease or increase the padding. Can be one of the following:
 *       - small: Applies a smaller padding.
 *       - large: Applies a larger padding.
 *   - header (optional): Content to display above the default card body.
 *   - footer (optional): Content to display below the default card body.
 */
function template_preprocess_uk_card(&$variables) {
  $modifiers = $variables['modifiers'];
  $style = $modifiers['style'];
  $hover = isset($modifiers['hover']) && $modifiers['hover'];
  $size = isset($modifiers['size']) ? $modifiers['size'] : FALSE;

  $attributes = new Attribute($variables['attributes']);
  $body_attributes = new Attribute();
  $attributes->addClass('uk-card');
  $attributes->addClass("uk-card-$style");

  if ($variables['header'] || $variables['footer']) {
    $body_attributes->addClass('uk-card-body');
  }
  else {
    $attributes->addClass('uk-card-body');
  }

  if ($hover) {
    $attributes->addClass('uk-card-hover');
  }
  if ($size) {
    $attributes->addClass("uk-card-$size");
  }

  $variables['attributes'] = $attributes;
  $variables['body_attributes'] = $body_attributes;
}

/**
 * Prepares variables for UIkit Countdown templates.
 *
 * Default template: uk-countdown.html.twig.
 *
 * @param $variables
 *   An associative array containing:
 *   - expire_date: The date when the countdown should expire using the ISO
 *     8601 format, e.g. 2017-12-04T22:00:00+00:00 (UTC time).
 *   - separators: An associative array to insert a separator between each
 *     number, containing:
 *     - days_hours: The separator to insert between the days and hours.
 *     - hours_minutes: The separator to insert between hours and minutes.
 *     - minutes_seconds: The separator to insert between minutes and seconds.
 *   - labels: An associative array for labels to display below each number,
 *     containing:
 *     - days: The label to display for days.
 *     - hours: The label to display for hours.
 *     - minutes: The label to display for minutes.
 *     - seconds: The label to display for seconds.
 */
function template_preprocess_uk_countdown(&$variables) {
  $date = $variables['expire_date'];

  $attributes = new Attribute();
  $attributes->addClass('uk-grid-small');
  $attributes->addClass('uk-child-width-auto');
  $attributes->setAttribute('uk-grid', '');
  $attributes->setAttribute('uk-countdown', "date: $date");
  $variables['attributes'] = $attributes;
}

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
