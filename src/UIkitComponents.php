<?php

namespace Drupal\uikit_components;

use Drupal\Core\Url;
use Symfony\Component\Yaml\Yaml;

/**
 * Class UIkitComponents
 *
 * Provides helper functions for the UIkit Components module.
 */
class UIkitComponents {

  /**
   * Loads a theme include file.
   *
   * This function essentially does the same as Drupal core's
   * module_load_include() function, except targeting theme include files. It also
   * allows you to place the include files in a sub-directory of the theme for
   * better organization.
   *
   * Examples:
   * @code
   *   // Load includes/uikit_subtheme.admin.inc from the node module.
   *   uikit_theme_load_include('inc', 'uikit_subtheme', 'uikit_subtheme.admin', 'includes');
   *   // Load preprocess.inc from the uikit_subtheme theme.
   *   uikit_theme_load_include('inc', 'uikit_subtheme', 'preprocess');
   * @endcode
   *
   * Do not use this function in a global context since it requires Drupal to be
   * fully bootstrapped, use require_once DRUPAL_ROOT . '/path/file' instead.
   *
   * @param string $type
   *   The include file's type (file extension).
   * @param string $theme
   *   The theme to which the include file belongs.
   * @param string $name
   *   (optional) The base file name (without the $type extension). If omitted,
   *   $theme is used; i.e., resulting in "$theme.$type" by default.
   * @param string $sub_directory
   *   (optional) The sub-directory to which the include file resides.
   *
   * @return string
   *   The name of the included file, if successful; FALSE otherwise.
   */
  public static function uikit_theme_load_include($type, $theme, $name = NULL, $sub_directory = '') {
    static $files = [];

    if (isset($sub_directory)) {
      $sub_directory = '/' . $sub_directory;
    }

    if (!isset($name)) {
      $name = $theme;
    }

    $key = $type . ':' . $theme . ':' . $name . ':' . $sub_directory;

    if (isset($files[$key])) {
      return $files[$key];
    }

    if (function_exists('drupal_get_path')) {
      $file = DRUPAL_ROOT . '/' . drupal_get_path('theme', $theme) . "$sub_directory/$name.$type";
      if (is_file($file)) {
        require_once $file;
        $files[$key] = $file;
        return $file;
      }
      else {
        $files[$key] = FALSE;
      }
    }
    return FALSE;
  }

  /**
   * Get the library version from the UIkit base theme.
   *
   * @return string
   *   The major version of the UIkit library from the install UIkit base theme.
   */
  public static function getUIkitLibraryVersion() {
    $theme_list = \Drupal::service('theme_handler')->listInfo();

    // Translatable strings.
    $t_args = [
      ':uikit_project' => Url::fromUri('https://www.drupal.org/project/uikit')->toString(),
      ':themes_page' => Url::fromRoute('system.themes_page')->toString(),
    ];

    if (isset($theme_list['uikit'])) {
      $uikit_libraries = Yaml::parse(drupal_get_path('theme', 'uikit') . '/uikit.libraries.yml');
      $uikit_version = explode('.', $uikit_libraries['uikit']['version']);

      return implode('.', $uikit_version);
    }
    else {
      drupal_set_message(t('The UIkit base theme is either not installed or could not be found. Please <a href=":uikit_project" target="_blank">download</a> and <a href=":themes_page">install</a> UIkit.', $t_args), 'error');
      return FALSE;
    }
  }
}
