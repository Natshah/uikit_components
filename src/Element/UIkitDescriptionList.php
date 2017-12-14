<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Description List component.
 *
 * Properties:
 * - #items: An array of items to be displayed in the description list. Each
 *   item can be an associative array with the properties "term" and
 *   "description", or be a string if the definition should be displayed with
 *   the previous item's term.
 * - #divider: A boolean indicating whether to add a horizontal line between
 *   list items. Defaults to FALSE.
 *
 * Usage example:
 * @code
 * $build['description_list'] = [
 *   '#type' => 'uikit_description_list',
 *   '#items' => [
 *     [
 *       'term' => t('Item 1'),
 *       'description' => t($item_one),
 *     ],
 *     [
 *       'term' => t('Item 2'),
 *       'description' => t($item_two),
 *     ],
 *     t($item_three),
 *   ],
 *   '#divider' => TRUE,
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_definition_list()
 * @see https://getuikit.com/docs/definition-list
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_description_list")
 */
class UIkitDescriptionList extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#items' => NULL,
      '#divider' => FALSE,
      '#attributes' => new Attribute(),
      '#pre_render' => [
        [$class, 'preRenderUIkitDescriptionList'],
      ],
      '#theme_wrappers' => ['uikit_description_list'],
    ];
  }

  /**
   * Pre-render callback: Sets the description list attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the description
   * list.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitDescriptionList($element) {
    // Set the attributes for the definition list.
    $element['#attributes']->addClass('uk-description-list');

    if ($element['#divider']) {
      // Add the divider class to the definition list.
      $element['#attributes']->addClass('uk-description-list-divider');
    }

    return $element;
  }

}
