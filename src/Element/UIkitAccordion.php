<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element for a group of form elements.
 *
 * Available properties:
 * - #items: An array of items to be displayed in the accordion. Each item must
 *   contain the title and content properties.
 * - #component_options: An array containing the component options to apply to
 *   the accordion. These must be in the form of "option: value" in order to
 *   work correctly.
 *
 * Usage example:
 * @code
 * $form['author'] = [
 *   '#type' => 'uikit_accordion',
 *   '#items' => [
 *     [
 *       'title' => $this->t('Item 1'),
 *       'content' => Markup::create($item_one),
 *     ],
 *     [
 *       'title' => $this->t('Item 2'),
 *       'content' => Markup::create($item_two),
 *     ],
 *     [
 *       'title' => $this->t('Item 3'),
 *       'content' => Markup::create($item_three),
 *     ],
 *   ],
 *   '#component_options' => [
 *     'multiple: false',
 *     'duration: 500',
 *   ],
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_accordion()
 * @see https://getuikit.com/docs/accordion#component-options
 *
 * @RenderElement("uikit_accordion")
 */
class UIkitAccordion extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#items' => NULL,
      '#component_options' => NULL,
      '#process' => [
        [$class, 'processGroup'],
        [$class, 'processAjaxForm'],
      ],
      '#pre_render' => [
        [$class, 'preRenderGroup'],
      ],
      '#theme_wrappers' => ['uikit_accordion'],
    ];
  }

}
