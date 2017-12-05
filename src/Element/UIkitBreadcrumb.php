<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element for the Breadcrumb component.
 *
 * Properties:
 * - #items: An array of items to be displayed in the breadcrumb. Each item must
 *   contain the text property and can optionally contain the url property to
 *   display the item as a link. Each item can also contain a disabled property
 *   to set the item as disabled using 'disabled' => TRUE.
 *
 * Usage example:
 * @code
 * $build['breadcrumb'] = [
 *   '#type' => 'uikit_breadcrumb',
 *   '#items' => [
 *     [
 *       'text' => t('Item 1'),
 *       'url' => Url::fromRoute('<front>'),
 *     ],
 *     [
 *       'text' => t('Item 2'),
 *       'url' => Url::fromRoute($route_two),
 *     ],
 *     [
 *       'text' => t('Disabled'),
 *       'url' => Url::fromRoute($route_three),
 *       'disabled' => TRUE,
 *     ],
 *     [
 *       'text' => t('Active'),
 *     ],
 *   ],
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_breadcrumb()
 * @see https://getuikit.com/docs/breadcrumb
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_breadcrumb")
 */
class UIkitBreadcrumb extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return [
      '#items' => NULL,
      '#theme_wrappers' => ['uikit_breadcrumb'],
    ];
  }

}
