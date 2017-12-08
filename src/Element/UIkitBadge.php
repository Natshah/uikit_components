<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Badge component.
 *
 * Properties:
 * - #value: The value of the badge.
 *
 * Usage example:
 * @code
 * $build['badge'] = [
 *   '#type' => 'uikit_badge',
 *   '#value' => '100',
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_badge()
 * @see https://getuikit.com/docs/badge
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_badge")
 */
class UIkitBadge extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#value' => NULL,
      '#attributes' => new Attribute(),
      '#pre_render' => [
        [$class, 'preRenderUIkitBadge'],
      ],
      '#theme_wrappers' => ['uikit_badge'],
    ];
  }

  /**
   * Pre-render callback: Sets the badge attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the badge.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitBadge($element) {
    // Set the attributes for the badge outer element.
    $element['#attributes']->addClass('uk-badge');

    return $element;
  }

}
