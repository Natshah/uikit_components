<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Alert component.
 *
 * Properties:
 * - #message: The message to display in the alert.
 * - #style: The style of the alert. Possible values:
 *   - primary: Give the message a prominent styling.
 *   - success: Indicates success or a positive message.
 *   - warning: Indicates a message containing a warning.
 *   - danger: Indicates an important or error message.
 *   Defaults to "primary".
 * - #close_button: Boolean indicating whether to include a close button in the
 *   alert. Defaults to FALSE.
 *
 * Usage example:
 * @code
 * $build['alert'] = [
 *   '#type' => 'uikit_alert',
 *   '#message' => $this->t('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.'),
 *   '#style' => 'warning',
 *   '#close_button' => TRUE,
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_alert()
 * @see https://getuikit.com/docs/alert
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_alert")
 */
class UIkitAlert extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#attributes' => new Attribute(),
      '#message' => NULL,
      '#style' => 'primary',
      '#close_button' => FALSE,
      '#pre_render' => [
        [$class, 'preRenderUIkitAlert'],
      ],
      '#theme_wrappers' => ['uikit_alert'],
    ];
  }

  /**
   * Pre-render callback: Sets the alert attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the alert.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitAlert($element) {
    // Set the attributes for the alert outer element.
    $element['#attributes']->addClass('uk-alert');
    $element['#attributes']->setAttribute('uk-alert', '');

    return $element;
  }

}
