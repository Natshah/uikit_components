<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element for the Article component.
 *
 * Properties:
 * - #title: The title of the article.
 * - #meta: The metadata of the article, such as author and created date.
 * - #lead: The lead to display before the article content.
 * - #content: The content of the article.
 *
 * Usage example:
 * @code
 * $build['article'] = [
 *   '#type' => 'uikit_article',
 *   '#title' => $this->t('Heading'),
 *   '#meta' => Markup::create($meta),
 *   '#lead' => $this->t('Lorem ipsum dolor sit amet'),
 *   '#content' => Markup::create($content),
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_article()
 * @see https://getuikit.com/docs/article
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_article")
 */
class UIkitArticle extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return [
      '#title' => NULL,
      '#meta' => NULL,
      '#lead' => NULL,
      '#content' => NULL,
      '#theme_wrappers' => ['uikit_article'],
    ];
  }

}
