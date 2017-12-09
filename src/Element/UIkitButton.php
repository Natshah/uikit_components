<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Button component.
 *
 * Properties:
 * - #text: The text to display in the button.
 * - #url: The url to use in the button, if the button should be rendered in an
 *   @code <a> @endcode element. If omitted, the button will be rendered in a
 *   @code <button> @endcode element.
 * - #style: The style of the button. Possible values:
 *   - default: Default button style.
 *   - primary: Indicates the primary action.
 *   - secondary: Indicates an important action.
 *   - danger: Indicates a dangerous or negative action.
 *   - text: Applies an alternative, typographic style.
 *   - link: Makes a @code <button> @endcode look like an @code <a> @endcode
 *     element.
 *   Defaults to "default".
 * - #size: The size of the button. Possible values are "small" and "large".
 * - #full_width: A boolean indicating if the button will take up the full width
 *   of the parent element. Defaults to FALSE.
 * - #disabled: A boolean indicating whether the button is disabled or not.
 *
 * Usage example:
 * @code
 * $build['button'] = [
 *   '#type' => 'uikit_button',
 *   '#text' => t('Button'),
 *   '#url' => Url::fromRoute('<front>')->toString(),
 *   '#style' => 'primary',
 *   '#size' => 'large',
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_button()
 * @see https://getuikit.com/docs/button
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_button")
 */
class UIkitButton extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#text' => NULL,
      '#url' => NULL,
      '#style' => 'default',
      '#size' => NULL,
      '#full_width' => FALSE,
      '#disabled' => FALSE,
      '#attributes' => new Attribute(),
      '#pre_render' => [
        [$class, 'preRenderUIkitButton'],
      ],
      '#theme_wrappers' => ['uikit_button'],
    ];
  }

  /**
   * Pre-render callback: Sets the button attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the button.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitButton($element) {
    // Set the attributes for the button element.
    $element['#attributes']->addClass('uk-button');
    $element['#attributes']->addClass('uk-button-' . $element['#style']);
    if (!empty($element['#size'])) {
      $element['#attributes']->addClass('uk-button-' . $element['#size']);
    }
    if ($element['#full_width']) {
      $element['#attributes']->addClass('uk-width-1-1');
    }
    if ($element['#disabled']) {
      $element['#attributes']->setAttribute('disabled', '');
    }
    if (!empty($element['#url'])) {
      $element['#attributes']->setAttribute('href', $element['#url']);
    }

    return $element;
  }

}
