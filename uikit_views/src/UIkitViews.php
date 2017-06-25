<?php

namespace Drupal\uikit_views;

use Drupal\Component\Utility\Html;
use Drupal\views\ViewExecutable;

/**
 * Class UIkitViews
 */
class UIkitViews {

  /**
   * Returns the theme hook definition information for UIkit Views.
   */
  public static function getThemeHooks() {
    $hooks['uikit_view_grid'] = [
      'preprocess functions' => [
        'template_preprocess_uikit_view_grid',
        'template_preprocess_views_view_grid',
      ],
      'file' => 'includes/uikit_views.theme.inc',
    ];
    $hooks['uikit_view_list'] = [
      'preprocess functions' => [
        'template_preprocess_uikit_view_list',
        'template_preprocess_views_view_list',
      ],
      'file' => 'includes/uikit_views.theme.inc',
    ];
    $hooks['uikit_view_table'] = [
      'preprocess functions' => [
        'template_preprocess_uikit_view_table',
        'template_preprocess_views_view_table',
      ],
      'file' => 'includes/uikit_views.theme.inc',
    ];

    return $hooks;
  }

  /**
   * Get unique element id.
   *
   * @param \Drupal\views\ViewExecutable $view
   *   A ViewExecutable object.
   *
   * @return string
   *   A unique id for an HTML element.
   */
  public static function getUniqueId(ViewExecutable $view) {
    $id = $view->storage->id() . '-' . $view->current_display;
    return Html::getUniqueId('views-uikit-' . $id);
  }

}
