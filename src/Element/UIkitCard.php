<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Card component.
 *
 * Properties:
 * - #content: The content of the card.
 * - #title (optional): The title of the card.
 * - #style (optional): The style of the card. Defaults to "default".
 * - #hover (optional): Add hover effect to card. Defaults to FALSE.
 * - #size (optional): The padding to apply to the card.
 * - #badge (optional): The badge to apply to the card.
 * - #header (optional): The heading to add to the card.
 * - #footer (optional): The footer to add to the card.
 * - #media (optional): An associative array containing:
 *   - alignment: Where the media is aligned in the card. Possible values are
 *     top or bottom. Left and right alignment is not currently available.
 *   - image_url: The URL for the image to display in the card.
 *
 * If #media is set, #header and #footer will be ignored. This prevents the
 * layout from being disrupted when #media is set. Since left and right media
 * layouts are too complex, left and right alignment values are currently
 * unavailable. See the documentation link below for more information.
 *
 * Usage example:
 * @code
 * $build['card'] = [
 *   '#type' => 'uikit_card',
 *   '#title' => $this->t('Title'),
 *   '#content' => Markup::create($content),
 *   '#style' => 'default',
 *   '#hover' => TRUE,
 *   '#size' => 'large',
 *   '#badge' => $this->t('Badge'),
 *   '#header' => $this->t('Heading'),
 *   '#footer' => Markup::create($footer),
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_card()
 * @see https://getuikit.com/docs/card
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_card")
 */
class UIkitCard extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#title' => NULL,
      '#content' => NULL,
      '#attributes' => new Attribute(),
      '#style' => 'default',
      '#hover' => FALSE,
      '#size' => NULL,
      '#badge' => NULL,
      '#header' => NULL,
      '#footer' => NULL,
      '#media' => NULL,
      '#pre_render' => [
        [$class, 'preRenderUIkitCard'],
      ],
      '#theme_wrappers' => ['uikit_card'],
    ];
  }

  /**
   * Pre-render callback: Sets the card attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the card.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitCard($element) {
    // Set the attributes for the card outer element.
    $element['#attributes']->addClass('uk-card');
    $element['#attributes']->addClass('uk-card-' . $element['#style']);

    if ($element['#hover']) {
      $element['#attributes']->addClass('uk-card-hover');
    }
    if (!empty($element['#size'])) {
      $element['#attributes']->addClass('uk-card-' . $element['#size']);
    }

    return $element;
  }

}
