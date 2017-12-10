<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Cover component.
 *
 * Properties:
 *
 * Usage example:
 * @code
 * $build['cover'] = [
 *   '#type' => 'uikit_cover',
 * ];
 * @endcode
 *
 *
 *
 * @see template_preprocess_uikit_cover()
 * @see https://getuikit.com/docs/cover
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_cover")
 */
class UIkitCover extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#media_type' => NULL,
      '#content' => NULL,
      '#responsive_height' => NULL,
      '#viewport_height' => NULL,
      '#component_options' => [],
      '#attributes' => new Attribute(),
      '#pre_render' => [
        [$class, 'preRenderUIkitCover'],
      ],
      '#theme_wrappers' => ['uikit_cover'],
    ];
  }

  /**
   * Pre-render callback: Sets the cover attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the cover.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitCover($element) {
    // Set the attributes for the badge outer element.
    $element['#attributes']->addClass('uk-cover-container');

    return $element;
  }

}
