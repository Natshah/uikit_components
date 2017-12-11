<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;
use Drupal\uikit_components\ImageStyleRenderer;

/**
 * Provides a render element for the Comment component.
 *
 * Properties:
 * - #avatar: An assocative array containing:
 *   - style_name: The name of the image style to be applied.
 *   - uri: URI of the source image before styling.
 *   - height: The height of the image.
 *   - width: The width of the image.
 *   - alt: The alternative text for text-based browsers. HTML 4 and XHTML 1.0
 *     always require an alt attribute. The HTML 5 draft allows the alt
 *     attribute to be omitted in some cases. Therefore, this variable defaults
 *     to an empty string, but can be set to NULL for the attribute to be
 *     omitted. Usually, neither omission nor an empty string satisfies
 *     accessibility requirements, so it is strongly encouraged for code using
 *     '#theme' => 'image_style' to pass a meaningful value for this variable.
 *     - http://www.w3.org/TR/REC-html40/struct/objects.html#h-13.8
 *     - http://www.w3.org/TR/xhtml1/dtds.html
 *     - http://dev.w3.org/html5/spec/Overview.html#alt
 *   - title: The title text is displayed when the image is hovered in some
 *     popular browsers.
 *   - attributes: Associative array of attributes to be placed in the img tag.
 * - #title: The title to display in the comment header.
 * - #meta: An array containing the metadata to display in the comment header.
 * - #comment: The content to display for the comment body.
 * - #primary: Boolean indicating whether to style a comment differently, for
 *   example to highlight it as the admin's comment.
 *
 * Usage example:
 * @code
 * $build['comment'] = [
 *   '#type' => 'uikit_comment',
 *   '#avatar' => [
 *     'style_name' => 'thumbnail',
 *     'uri' => 'public://avatar.jpg',
 *     'height' => '80',
 *     'width' => '80',
 *     'alt' => t('Avatar'),
 *     'title' => t('Author'),
 *   ],
 *   '#title' => Markup::create('<a class="uk-link-reset" href="#">Author</a>'),
 *   '#meta' => [
 *     Markup::create('<a href="#">12 days ago</a>'),
 *     Markup::create('<a href="#">Reply</a>'),
 *   ],
 *   '#comment' => Markup::create('<p>Lorem ipsum dolor sit amet.</p>'),
 *   '#primary' => TRUE,
 * ];
 * @endcode
 *
 * @see template_preprocess_image_style()
 * @see template_preprocess_uikit_comment()
 * @see https://getuikit.com/docs/comment
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_comment")
 */
class UIkitComment extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#avatar' => [
        'style_name' => NULL,
        'uri' => NULL,
      ],
      '#title' => NULL,
      '#meta' => NULL,
      '#comment' => NULL,
      '#primary' => FALSE,
      '#attributes' => new Attribute(),
      '#pre_render' => [
        [$class, 'preRenderUIkitComment'],
      ],
      '#theme_wrappers' => ['uikit_comment'],
    ];
  }

  /**
   * Pre-render callback: Sets the comment attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the comment.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitComment($element) {
    // Set the attributes for the comment outer element.
    $element['#attributes']->addClass('uk-comment');
    if ($element['#primary']) {
      $element['#attributes']->addClass('uk-comment-primary');
    }

    // Set the variables for the avatar so it can be rendered as an image style.
    if (!empty($element['#avatar'])) {
      $avatar = $element['#avatar'];

      // Check if the file exists before continuing.
      if (file_exists($avatar['uri'])) {
        // Set the #avatar variable to render the image using the given image
        // style.
        $managed_file = ImageStyleRenderer::loadImageManagedFile($avatar);
        if ($managed_file) {
          // First check if this is a managed file and set the #avatar variable
          // using our image style rendering class.
          $element['#avatar'] = $managed_file;
        }
        else {
          // Otherwise build the avatar using a simpler method, with less
          // information being added to the #avatar variable.
          $element['#avatar'] = ImageStyleRenderer::loadImageFile($avatar);
        }

        // Set the attributes to the avatar.
        $element['#avatar']['#attributes'] = new Attribute();
        $element['#avatar']['#attributes']->addClass('uk-comment-avatar');

        // Recursively merge the user-defined attributes with the avatar
        // attributes, if the user assigned additional attributes.
        if (isset($avatar['attributes'])) {
          $element['#avatar']['#attributes'] = array_merge_recursive($element['#avatar']['#attributes'], $avatar['attributes']);
        }

        // Add the alt, title, height and width attributes, if they are set.
        if (isset($avatar['alt'])) {
          $element['#avatar']['#alt'] = $avatar['alt'];
        }
        if (isset($avatar['title'])) {
          $element['#avatar']['#title'] = $avatar['title'];
        }
        if (isset($avatar['height'])) {
          $element['#avatar']['#height'] = $avatar['height'];
        }
        if (isset($avatar['width'])) {
          $element['#avatar']['#width'] = $avatar['width'];
        }
      }
      else {
        $element['#avatar'] = [];
      }
    }

    return $element;
  }

}
