<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Video component.
 *
 * Properties:
 * - #embed_iframe: The embed code to display the video. This should be the
 *   the full embed code from the video's source and contain the
 *   @code <iframe> @endcode element. The various embed options, such as
 *   displaying the video controls, should also be included. If this is set,
 *   do not set the #video_sources property.
 * - #video_sources: An array of full-qualified URLs to the video sources. Each
 *   source should have a different video extension to provide a fallback
 *   source for browser compatibility. If only one source is provided and the
 *   browser does not support the video's file extension, the video will not
 *   display. If this is set, do not set the #embed_iframe property.
 * - #display_controls: A boolean indicating whether to display the controls
 *   when the #video_sources property is set. This is ignored if the
 *   #embed_iframe property is set.
 * - #component_options: An array containing the component options to apply to
 *   the video. These must be in the form of "option: value" in order to work
 *   correctly.
 *
 * Usage example:
 * @code
 * $build['video'] = [
 *   '#type' => 'uikit_video',
 *   '#embed_iframe' => $iframe_embed_code,
 *   '#display_controls' => TRUE,
 *   '#component_options' => [
 *     'autoplay: false',
 *   ],
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_video()
 * @see https://getuikit.com/docs/utility#video
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_video")
 */
class UIkitVideo extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#embed_iframe' => NULL,
      '#video_sources' => [],
      '#display_controls' => FALSE,
      '#component_options' => [],
      '#attributes' => new Attribute(),
      '#pre_render' => [
        [$class, 'preRenderUIkitVideo'],
      ],
      '#theme_wrappers' => ['uikit_video'],
    ];
  }

  /**
   * Pre-render callback: Sets the video attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the video.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitVideo($element) {
    // Prepare the component options for the video.
    $component_options = '';
    if (!empty($element['#component_options'])) {
      $component_options = implode('; ', $element['#component_options']);
    }

    // Set the attributes for the video element.
    if (!empty($element['#video_sources'])) {
      if ($element['#display_controls']) {
        $element['#attributes']->setAttribute('controls', '');
      }
      if ($element['#plays_inline']) {
        $element['#attributes']->setAttribute('playsinline', '');
      }
    }
    $element['#attributes']->setAttribute('uk-video', $component_options);

    return $element;
  }

}
