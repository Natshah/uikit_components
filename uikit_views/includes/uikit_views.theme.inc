<?php

/**
 * @file
 * Preprocessors and helper functions to make theming easier.
 */

use Drupal\Core\Template\Attribute;
use Drupal\uikit_views\UIkitViews;

/**
 * Prepares variables for UIkit Accordion templates.
 *
 * Default template: uikit-view-accordion.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_accordion(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;
  $title_field = $options['title_field'];
  $accordion_data = [];
  $items = [];

  if ($title_field) {
    foreach ($variables['rows'] as $result_index => $item) {
      $title = $view->style_plugin->getFieldValue($result_index, $title_field);
      $items[$result_index]['content'] = $item;
      $items[$result_index]['title'] = $title;
    }
  }

  // Set items array for twig template.
  $variables['items'] = $items;

  // Create attributes for accordion.
  $accordion_data[] = 'targets: ' . ($options['targets'] ? $options['targets'] : '> *');
  $accordion_data[] = 'active: ' . ($options['active'] ? $options['active'] : 'false');
  $accordion_data[] = 'collapsible: ' . ($options['collapsible'] ? 'true' : 'false');
  $accordion_data[] = 'multiple: ' . ($options['multiple'] ? 'true' : 'false');
  $accordion_data[] = 'animation: ' . ($options['animation'] ? 'true' : 'false');
  $accordion_data[] = 'transition: ' . $options['transition'];
  $accordion_data[] = 'duration: ' . $options['duration'];
  $data_accordion = implode('; ', $accordion_data);

  $accordion_attributes = new Attribute();
  $accordion_attributes->addClass('uk-accordion');
  $accordion_attributes->setAttribute('uk-accordion', $data_accordion);

  // Set accordion attributes for twig template.
  $variables['accordion_attributes'] = $accordion_attributes;
}

/**
 * Prepares variables for UIkit Grid templates.
 *
 * Default template: uikit-view-grid.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_grid(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;

  $grid_attributes = new Attribute();
  $variables['id'] = UIkitViews::getUniqueId($view);

  if ($options['grid_lightbox'] == TRUE) {
    $grid_attributes->setAttribute('uk-lightbox', 'true');
  }

  $grid_attributes->setAttribute('uk-grid', '');
  $grid_attributes->setAttribute('class', 'uk-grid');

  if ($options['grid_behavior'] == 'masonry') {
    $grid_attributes->setAttribute('uk-grid', 'masonry: true');
  }

  $grid_classes = [];

  if ($options['grid_behavior'] == 'match' && $options['grid_match_height_selector'] == NULL) {
    $grid_classes[] = 'uk-grid-match';
  }

  if ($options['grid_behavior'] == 'match' && $options['grid_match_height_selector'] != NULL) {
    $grid_attributes->setAttribute('uk-height-match', 'target: ' . $options['grid_match_height_selector']);
  }

  if ($options['flex_classes'] != NULL) {
    $grid_classes += explode (' ', $options['flex_classes']);
  }

  if ($options['grid_gutter'] != 'default') {
    $grid_classes[] = $options['grid_gutter'];
  }

  if ($options['grid_divider'] == TRUE) {
    $grid_classes[] = 'uk-grid-divider';
  }

  foreach (['', '@s', '@m', '@l', '@xl'] as $size) {
    $grid_classes[] = $options["width_" . $size];
  }

  $grid_attributes->addClass($grid_classes);

  $variables['grid_attributes'] = $grid_attributes;
  $variables['options'] = $options;

  $items = [];

  // Iterate over each rendered views result row.
  foreach ($variables['rows'] as $result_index => $item) {
    $items[$result_index]['content'] = $item;
  }

  // Add items to the variables array.
  $variables['items'] = $items;
}

/**
 * Prepares variables for UIkit List templates.
 *
 * Default template: uikit-view-list.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_list(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;

  // Set the wrapper attributes.
  $variables['attributes'] = new Attribute();
  if ($options['wrapper_class']) {
    $variables['attributes']->addClass($options['wrapper_class']);
  }

  // Set the list attributes.
  $variables['list_attributes'] = new Attribute();
  $variables['list_attributes']['class'] = ['uk-list'];

  if ($options['class'] != 'default') {
    $variables['list_attributes']['class'][] = $options['class'];
  }

  $items = [];

  // Iterate over each rendered views result row.
  foreach ($variables['rows'] as $result_index => $item) {
    $items[$result_index]['content'] = $item;
  }

  // Add items to the variables array.
  $variables['items'] = $items;
}

/**
 * Prepares variables for UIkit Slideshow templates.
 *
 * Default template: uikit-view-slideshow.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_slider(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;

  // Add option to the variables array.
  foreach ($options as $option => $value) {
    $variables[$option] = $value;
  }

  $items = [];
  // Iterate over each rendered views result row.
  foreach ($variables['rows'] as $result_index => $item) {
    $items[$result_index]['content'] = $item;
    if ($options['image_field']) {
      $image = $view->style_plugin->getField($result_index, $options['image_field']);
      $items[$result_index]['image'] = $image;
    }
    if ($options['title_field']) {
      $title = $view->style_plugin->getField($result_index, $options['title_field']);
      $items[$result_index]['title'] = $title;
    }
    if ($options['caption_field']) {
      $caption = $view->style_plugin->getField($result_index, $options['caption_field']);
      $items[$result_index]['caption'] = $caption;
    }
    if ($options['thumbnav'] && $options['thumbnav_field']) {
      $thumbnail = $view->style_plugin->getField($result_index, $options['thumbnav_field']);
      $items[$result_index]['thumbnail'] = $thumbnail;
    }
  }
  // Add items to the variables array.
  $variables['items'] = $items;

  // Create slider attributes for template.
  $slider_data = [];
  $slider_data[] = 'autoplay: ' . $options['autoplay'];
  $slider_data[] = 'autoplay-interval: ' . $options['autoplay_interval'];
  if($options['center']) {
    $slider_data[] = 'center: ' . $options['center'];
  }
  if($options['finite']) {
    $slider_data[] = 'finite: ' . $options['finite'];
  }
  $slider_data[] = 'index: ' . $options['index'];
  if($options['pause_on_hover']) {
    $slider_data[] = 'pause-on-hover: ' . $options['pause_on_hover'];
  }
  if($options['sets']) {
    $slider_data[] = 'sets: ' . $options['sets'];
  }
  $slider_data[] = 'velocity: ' . $options['velocity'];
  if ($options['caption_transition'] != NULL && $options['caption_toggle'] == FALSE) {
    $slider_data[] = 'clsActivated: uk-transition-active';
  }
  $data_slider = implode('; ', $slider_data);
  // Add slider_attributes to the variables array.
  $variables['slider_attributes'] = new Attribute(['uk-slider'=> $data_slider]);

  // Create grid attribute for template.
  $grid_attributes = new Attribute(['uk-grid' => "", 'class' => ['uk-slider-items', 'uk-grid']]);
  if ($options['grid_gutter'] != NULL) {
    $grid_attributes->addClass($options['grid_gutter']);
  }
  foreach (['', '@s', '@m', '@l', '@xl'] as $size) {
    $grid_attributes->addClass($options["width_" . $size]);
  }
  if ($options['grid_match_height'] == TRUE && $options['grid_match_height_selector'] == NULL) {
    $grid_attributes->addClass('uk-grid-match');
  }
  if ($options['grid_match_height'] == TRUE && $options['grid_match_height_selector'] != NULL) {
    $grid_attributes->setAttribute('uk-height-match', 'target: ' . $options['grid_match_height_selector']);
  }
  // Add grid_attributes to the variables array.
  $variables['grid_attributes'] = $grid_attributes;

  // Create attributes for slidenav.
  $variables['slidenav_left_attributes'] = new Attribute(['uk-slidenav-previous' => "", 'uk-slider-item' => 'previous']);
  $variables['slidenav_right_attributes'] = new Attribute(['uk-slidenav-next' => "", 'uk-slider-item' => 'next']);

  // Set other necessary attributes variables for twig template.
  $variables['caption_attributes'] = new Attribute();
  $variables['panel_attributes'] = new Attribute();
}

/**
 * Prepares variables for UIkit Slideshow templates.
 *
 * Default template: uikit-view-slideshow.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_slideshow(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;

  // Add option to the variables array.
  foreach ($options as $option => $value) {
    $variables[$option] = $value;
  }

  $items = [];
  // Iterate over each rendered views result row.
  foreach ($variables['rows'] as $result_index => $item) {
    if ($options['image_field']) {
      $image = $view->style_plugin->getField($result_index, $options['image_field']);
      $items[$result_index]['image'] = $image;
    }
    if ($options['title_field']) {
      $title = $view->style_plugin->getField($result_index, $options['title_field']);
      $items[$result_index]['title'] = $title;
    }
    if ($options['caption_field']) {
        $caption = $view->style_plugin->getField($result_index, $options['caption_field']);
        $items[$result_index]['caption'] = $caption;
    }
    if ($options['thumbnav'] && $options['thumbnav_field']) {
        $thumbnail = $view->style_plugin->getField($result_index, $options['thumbnav_field']);
        $items[$result_index]['thumbnail'] = $thumbnail;
    }
  }
  // Add items to the variables array.
  $variables['items'] = $items;

  // Create attributes for slideshow.
  $slideshow_data = [];
  $slideshow_data[] = 'animation: ' . $options['animation'];
  $slideshow_data[] = 'autoplay: ' . $options['autoplay'];
  $slideshow_data[] = 'autoplay-interval: ' . $options['autoplay_interval'];
  $slideshow_data[] = 'finite: ' . $options['finite'];
  $slideshow_data[] = 'pause-on-hover: ' . $options['pause_on_hover'];
  $slideshow_data[] = 'index: ' . $options['index'];
  $slideshow_data[] = 'velocity: ' . $options['velocity'];
  $slideshow_data[] = 'ratio: ' . ($options['ratio'] ? $options['ratio'] : 'false');
  $slideshow_data[] = 'min-height: ' . (!empty($options['min_height']) ? $options['min_height'] : 'false');
  $slideshow_data[] = 'max-height: ' . (!empty($options['max_height']) ? $options['max_height'] : 'false');
  if ($options['caption_transition'] != NULL) {
    $transition = ($options['caption_toggle']) ? '': 'uk-transition-active';
    $slideshow_data[] = "clsActivated: $transition";
  }
  $data_slideshow = implode('; ', $slideshow_data);
  $variables['slideshow_attributes'] = new Attribute(['uk-slideshow' => $data_slideshow]);

  // Create attributes for slidenav.
  $variables['slidenav_left_attributes'] = new Attribute(['uk-slidenav-previous' => "", 'uk-slideshow-item' => 'previous']);
  $variables['slidenav_right_attributes'] = new Attribute(['uk-slidenav-next' => "", 'uk-slideshow-item' => 'next']);

  // Set other necessary attributes variables for twig template.
  $variables['caption_attributes'] = new Attribute();
  $variables['panel_attributes'] = new Attribute();
}

/**
 * Prepares variables for UIkit Table templates.
 *
 * Default template: uikit-view-table.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_uikit_view_table(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;

  // Add additional options as variables.
  $variables['responsive_table'] = $options['responsive_table'];
  $variables['vertical_modifier'] = $options['vertical_modifier'];

  // Add each table modifier option as variables.
  $table_modifiers = $options['table_modifiers'];
  foreach ($table_modifiers as $modifier_key => $modifier) {
    $variables[$modifier_key] = $modifier;
  }
}
