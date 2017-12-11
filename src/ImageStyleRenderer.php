<?php

namespace Drupal\uikit_components;

use Drupal\file\Entity\File;

/**
 * Class ImageStyleRenderer
 *
 * Provides methods to automatically return an array for imamge styles ready to
 * be processed by Drupal's render service.
 */
class ImageStyleRenderer {

  /**
   * @inheritdoc
   */
  public static function loadImageManagedFile($build) {
    $entity_manager = \Drupal::entityTypeManager()->getStorage('file');
    $query = $entity_manager->getQuery();
    $query->condition('uri', $build['uri']);
    $fids = $query->execute();

    if (count($fids) && $file = File::load(reset($fids))) {
      $variables = array(
        'style_name' => $build['style_name'],
        'uri' => $file->getFileUri(),
      );

      // The image.factory service will check if our image is valid.
      $image = \Drupal::service('image.factory')->get($file->getFileUri());

      if ($image->isValid()) {
        $variables['width'] = $image->getWidth();
        $variables['height'] = $image->getHeight();
      }
      else {
        $variables['width'] = $variables['height'] = NULL;
      }

      $build = [
        '#theme' => 'image_style',
        '#width' => $variables['width'],
        '#height' => $variables['height'],
        '#style_name' => $variables['style_name'],
        '#uri' => $variables['uri'],
      ];

      // Add the file entity to the cache dependencies.
      // This will clear our cache when this entity updates.
      $renderer = \Drupal::service('renderer');
      $renderer->addCacheableDependency($build, $file);

      // Return the render array.
      return $build;
    }
    else {
      // Image not found, return empty array.
      return [];
    }
  }

  /**
   * @inheritdoc
   */
  public static function loadImageFile($build) {
    return [
      '#theme' => 'image_style',
      '#style_name' => $build['style_name'],
      '#uri' => $build['uri'],
    ];
  }

}
