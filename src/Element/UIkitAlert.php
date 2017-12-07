<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;

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
 *   '#message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
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
    return [
      '#message' => NULL,
      '#style' => 'primary',
      '#close_button' => FALSE,
      '#theme_wrappers' => ['uikit_alert'],
    ];
  }

}
