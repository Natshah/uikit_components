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
 * Default template: uikit-accordion.html.twig.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing:
 *     - #items: An array of items to be displayed in the accordion. Each item
 *       must contain the title and content properties.
 *     - #component_options: An array containing the component options to apply
 *       to the accordion. These must be in the form of "option: value" in order
 *       to work correctly.
 *
 * @see \Drupal\uikit_components\Element\UIkitAccordion
 * @see https://getuikit.com/docs/accordion#component-options
 *
 * @ingroup uikit_components_theme_render
 */
function template_preprocess_uikit_accordion(&$variables) {
  $element = $variables['element'];

  // Set the items variable, if items is not empty.
  if (!empty($element['#items'])) {
    $variables['items'] = $element['#items'];
  }

  // Prepare the component options for the accordion.
  $component_options = '';
  if (!empty($element['#component_options'])) {
    $component_options = implode('; ', $element['#component_options']);
  }

  // Set the attributes for the accordion outer element.
  $variables['attributes'] = new Attribute();
  $variables['attributes']->addClass('uk-accordion');
  $variables['attributes']->setAttribute('uk-accordion', $component_options);
}

/**
 * Prepares variables for UIkit Article templates.
 *
 * Default template: uikit-article.html.twig.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing:
 *     - #title (optional): The title of the article.
 *     - #meta (optional): The metadata of the article, such as the author and
 *       created date.
 *     - #lead (optional): The leading paragraph of the article.
 *     - #content: The content of the article.
 *
 * @see \Drupal\uikit_components\Element\UIkitArticle
 * @see https://getuikit.com/docs/article
 *
 * @ingroup uikit_components_theme_render
 */
function template_preprocess_uikit_article(&$variables) {
  $element = $variables['element'];

  // Set the title, meta, lead and content variables, if they are not empty.
  if (!empty($element['#title'])) {
    $variables['title'] = $element['#title'];
  }
  if (!empty($element['#meta'])) {
    $variables['meta'] = $element['#meta'];
  }
  if (!empty($element['#lead'])) {
    $variables['lead'] = $element['#lead'];
  }
  if (!empty($element['#content'])) {
    $variables['content'] = $element['#content'];
  }

  // Set the attributes for the article outer element.
  $attributes = new Attribute();
  $attributes->addClass('uk-article');
  $variables['attributes'] = $attributes;
}

/**
 * Prrpares variables for UIkit Badge templates.
 *
 * Default template: uikit-badge.html.twig.
 *
 * @param $variables:
 *   An associative array containing:
 *   - element: An associative array containing:
 *     - #value: The value of the article.
 *
 * @see \Drupal\uikit_components\Element\UIkitBadge
 * @see https://getuikit.com/docs/badge
 *
 * @ingroup uikit_components_theme_render
 */
function template_preprocess_uikit_badge(&$variables) {
  $element = $variables['element'];

  // Set the attributes for the badge.
  $attributes = new Attribute();
  $attributes->addClass('uk-badge');
  $variables['attributes'] = $attributes;

  // Set the value for the badge, if not empty.
  if (!empty($element['#value'])) {
    $variables['value'] = $element['#value'];
  }
}

/**
 * Prepares variables for UIkit Breadcrumb templates.
 *
 * Default template: uikit-breadcrumb.html.twig.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing:
 *     - #items: An array of items to be displayed in the breadcrumb. Each item
 *       must contain the text property and can optionally contain the url
 *       property to display the item as a link. Each item can also contain a
 *       disabled property to set the item as disabled using 'disabled' => TRUE.
 *
 * @see \Drupal\uikit_components\Element\UIkitBreadcrumb
 * @see https://getuikit.com/docs/breadcrumb
 *
 * @ingroup uikit_components_theme_render
 */
function template_preprocess_uikit_breadcrumb(&$variables) {
  $element = $variables['element'];

  // Set the attributes for the breadcrumb.
  $attributes = new Attribute();
  $attributes->addClass('uk-breadcrumb');
  $variables['attributes'] = $attributes;

  // Set the items property.
  $variables['items'] = $element['#items'];

  foreach ($variables['items'] as $key => $item) {
    // Set the item attributes.
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
 * Default template: uikit-card.html.twig.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing:
 *     - #content: The content of the article.
 *     - #title (optional): The title of the card.
 *     - #style (optional): The style of the card. Defaults to "default".
 *     - #hover (optional): Add hover effect to card. Defaults to FALSE.
 *     - #size (optional): The padding to apply to the card.
 *     - #badge (optional): The badge to apply to the card.
 *     - #header (optional): The heading to add to the card.
 *     - #footer (optional): The footer to add to the card.
 *     - #media (optional): An associative array containing:
 *       - alignment: Where the media is aligned in the card. Possible values
 *         are top or bottom. Left and right alignment is not currently
 *         available.
 *       - image_url: The URL for the image to display in the card.
 *
 * If #media is set, #header and #footer will be ignored. This prevents the
 * layout from being disrupted when #media is set. Since left and right media
 * layouts are too complex, left and right alignment values are currently
 * unavailable. See the documentation link below for more information.
 *
 * @see \Drupal\uikit_components\Element\UIkitCard
 * @see https://getuikit.com/docs/card
 *
 * @ingroup uikit_components_theme_render
 */
function template_preprocess_uikit_card(&$variables) {
  $element = $variables['element'];

  // Set the title, content, badge, header, footer and media variables, if they
  // are not empty.
  if (!empty($element['#title'])) {
    $variables['title'] = $element['#title'];
  }
  if (!empty($element['#content'])) {
    $variables['content'] = $element['#content'];
  }
  if (!empty($element['#badge'])) {
    $variables['badge'] = $element['#badge'];
  }
  if (!empty($element['#header'])) {
    $variables['header'] = $element['#header'];
  }
  if (!empty($element['#footer'])) {
    $variables['footer'] = $element['#footer'];
  }
  if (!empty($element['#media'])) {
    $variables['media'] = $element['#media'];
  }

  // Set the attributes for the card.
  $attributes = new Attribute();
  $attributes->addClass('uk-card');
  $attributes->addClass('uk-card-' . $element['#style']);

  if ($element['#hover']) {
    $attributes->addClass('uk-card-hover');
  }
  if (!empty($element['#size'])) {
    $attributes->addClass('uk-card-' . $element['#size']);
  }
  if (!empty($element['#badge'])) {
    $variables['badge'] = $element['#badge'];
  }

  $variables['attributes'] = $attributes;
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
 * Implements template_preprocess_HOOK() for menu--uikit-list.html.twig.
 */
function template_preprocess_menu__uikit_list(&$variables) {
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
 * Implements template_preprocess_HOOK() for menu--uikit-nav.html.twig.
 */
function template_preprocess_menu__uikit_nav(&$variables) {
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
 * Implements template_preprocess_HOOK() for menu--uikit-subnav.html.twig.
 */
function template_preprocess_menu__uikit_subnav(&$variables) {
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
