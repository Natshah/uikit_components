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
   *   // Load node.admin.inc from the node module.
   *   UIkitComponents::loadIncludeFile('inc', 'node', 'module', 'node.admin');
   *
   *   // Load includes/alter.inc from the uikit theme.
   *   UIkitComponents::loadIncludeFile('inc', 'uikit', 'theme', 'preprocess', 'includes');
   * @endcode
   *
   * Do not use this function in a global context since it requires Drupal to be
   * fully bootstrapped, use require_once DRUPAL_ROOT . '/path/file' instead.
   *
   * @param string $type
   *   The include file's type (file extension).
   * @param string $project
   *   The project to which the include file belongs.
   * @param string $project_type
   *   The project type to which the include file belongs, either "theme" or
   *   "module". Defaults to "module".
   * @param string $name
   *   (optional) The base file name (without the $type extension). If omitted,
   *   $theme is used; i.e., resulting in "$theme.$type" by default.
   * @param string $sub_directory
   *   (optional) The sub-directory to which the include file resides.
   *
   * @return string
   *   The name of the included file, if successful; FALSE otherwise.
   */
  public static function loadIncludeFile($type, $project, $project_type = 'module', $name = NULL, $sub_directory = '') {
    static $files = [];

    if (isset($sub_directory)) {
      $sub_directory = '/' . $sub_directory;
    }

    if (!isset($name)) {
      $name = $project;
    }

    $key = $type . ':' . $project . ':' . $name . ':' . $sub_directory;

    if (isset($files[$key])) {
      return $files[$key];
    }

    if (function_exists('drupal_get_path')) {
      $file = DRUPAL_ROOT . '/' . drupal_get_path($project_type, $project) . "$sub_directory/$name.$type";
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

      return $uikit_libraries['uikit']['version'];
    }
    else {
      drupal_set_message(t('The UIkit base theme is either not installed or could not be found. Please <a href=":uikit_project" target="_blank">download</a> and <a href=":themes_page">install</a> UIkit.', $t_args), 'error');
      return FALSE;
    }
  }

  /**
   * Get the UIkit documentation URL for the given component.
   *
   * @param string $component
   *   The component to return a URL for.
   *
   * @return string
   *   Returns a URL for the given component.
   */
  public static function getComponentURL($component) {
    if (!$component) {
      drupal_set_message(t('URL cannot be returned, no component was given in <em class="placeholder">UIkitComponents::getComponentURL()</em>.'), 'warning');
      return;
    }
    else {
      $uri = 'https://getuikit.com/docs/' . $component;
      return Url::fromUri($uri)->toString();
    }
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @return bool
   *   Returns menu style if already set, FALSE otherwise.
   */
  public static function getMenuStyle($menu) {
    return \Drupal::state()->get($menu . '_menu_style') ?: 0;
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @param string $style
   *   The style value to set for the menu.
   */
  public static function setMenuStyle($menu, $value) {
    \Drupal::state()->set($menu . '_menu_style', $value);
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @return bool
   *   Returns menu style if already set, FALSE otherwise.
   */
  public static function getLargeList($menu) {
    return \Drupal::state()->get($menu . '_menu_style_list_large') ?: 0;
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @param string $style
   *   The style value to set for the menu.
   */
  public static function setLargeList($menu, $value) {
    \Drupal::state()->set($menu . '_menu_style_list_large', $value);
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @return bool
   *   Returns menu style if already set, FALSE otherwise.
   */
  public static function getNavStyleModifier($menu) {
    return \Drupal::state()->get($menu . '_menu_style_nav_style_modifiers') ?: 0;
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @param string $style
   *   The style value to set for the menu.
   */
  public static function setNavStyleModifier($menu, $value) {
    \Drupal::state()->set($menu . '_menu_style_nav_style_modifiers', $value);
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @return bool
   *   Returns menu style if already set, FALSE otherwise.
   */
  public static function getNavCenterModifier($menu) {
    return \Drupal::state()->get($menu . '_menu_style_nav_center_modifier') ?: 0;
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @param string $style
   *   The style value to set for the menu.
   */
  public static function setNavCenterModifier($menu, $value) {
    \Drupal::state()->set($menu . '_menu_style_nav_center_modifier', $value);
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @return bool
   *   Returns menu style if already set, FALSE otherwise.
   */
  public static function getNavWidthClasses($menu) {
    return \Drupal::state()->get($menu . '_menu_style_wrapper_widths') ?: 0;
  }

  /**
   * Returns the menu style, if already set.
   *
   * @param string $menu
   *   The name of the menu.
   *
   * @param string $style
   *   The style value to set for the menu.
   */
  public static function setNavWidthClasses($menu, $value) {
    \Drupal::state()->set($menu . '_menu_style_wrapper_widths', $value);
  }

}
