<?php

/**
 * @file
 * Documentation landing page and topics.
 */

/**
 * @mainpage UIkit Components
 * Welcome to the UIkit Components API Documentation!
 *
 * Newcomers to Drupal 8 module development should review the
 * @link https://www.drupal.org/docs/8/api Drupal 8 APIs @endlink and
 * @link https://www.drupal.org/docs/8/creating-custom-modules Creating custom modules @endlink.
 *
 * @section about_uikit About UIkit Components
 * The UIkit components module provides additional components and functionality
 * to the @link https://www.drupal.org/project/uikit UIkit @endlink base theme.
 *
 * Some aspects of the frontend cannot be themed without going through the
 * backend, such as empty navbar links. With this module you can add more
 * functionality to the UIkit frontend through the Drupal backend without the
 * need for contributed modules which may add more functionality than needed.
 *
 * Here are some topics to help you get started developing with UIkit
 * Components.
 * - @link uikit_components_theme_render Render API Overview @endlink
 */

/**
 * @defgroup uikit_components_theme_render Render API Overview
 * @{
 * Overview of the UIkit Components Theme system and Render API.
 *
 * Drupal's theme system gives themes complete control over the appearance of
 * the site. UIkit Components makes this easier for themers and developers,
 * without the need to learn complex code.
 *
 * Utilizing Drupal's Render API, UIkit Components defines several render
 * elements and provides default templates so users can rapid-develop themes
 * based on the UIkit framework with ease.
 *
 * @section uikit_components_render_elements Render Elements
 * UIkit Components defines render elements for some of the more basic UIkit
 * components available.
 *
 * Not all components are creating equal, however. Those
 * which do not make sense as a render element, such as components which simply
 * provide classes, will not be included with UIkit Components. These components
 * are already available with the UIkit base theme; simply assign the classes
 * to the elements you wish to add them to.
 *
 * Other more complex components, such as the
 * @link https://getuikit.com/docs/switcher Switcher component @endlink, have
 * not been added to UIkit Components just yet. It will take some time before
 * they are available as we are currently working on their development.
 *
 * Below you will find the various classes, functions and templates for render
 * elements UIkit Components currently provides.
 * @}
 */
