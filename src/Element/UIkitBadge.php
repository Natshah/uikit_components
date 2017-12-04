<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element for the Badge component.
 *
 * Available properties:
 * - #value: The value of the badge.
 *
 * Usage example:
 * @code
 * $build['badge'] = [
 *   '#type' => 'uikit_badge',
 *   '#value' => '100,
 * ];
 * @endcode
 *
 * @ingroup uikit_components_theme_render
 *
 * @see template_preprocess_uikit_badge()
 * @see https://getuikit.com/docs/badge
 *
 * @RenderElement("uikit_badge")
 */
class UIkitBadge extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return [
      '#value' => NULL,
      '#theme_wrappers' => ['uikit_badge'],
    ];
  }

}
