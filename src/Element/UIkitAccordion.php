<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Accordion component.
 *
 * Properties:
 * - #items: An array of items to be displayed in the accordion. Each item must
 *   contain the title and content properties.
 * - #component_options: An array containing the component options to apply to
 *   the accordion. These must be in the form of "option: value" in order to
 *   work correctly.
 *
 * Usage example:
 * @code
 * $form['accordion'] = [
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
 * @ingroup uikit_components_theme_render
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
      '#items' => [],
      '#component_options' => [],
      '#attributes' => new Attribute(),
      '#pre_render' => [
        [$class, 'preRenderUIkitAccordion'],
      ],
      '#theme_wrappers' => ['uikit_accordion'],
    ];
  }

  /**
   * Pre-render callback: Sets the accordion options and attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the accordion.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitAccordion($element) {
    // Prepare the component options for the accordion.
    $component_options = '';
    if (!empty($element['#component_options'])) {
      $component_options = implode('; ', $element['#component_options']);
    }

    // Set the attributes for the accordion outer element.
    $element['#attributes']->addClass('uk-accordion');
    $element['#attributes']->setAttribute('uk-accordion', $component_options);

    return $element;
  }
}
