<?php

namespace Drupal\uikit_views\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render each item in a UIkit Slider component.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "uikit_view_slider",
 *   title = @Translation("UIkit Slider"),
 *   help = @Translation("Displays rows in a UIkit Slider component"),
 *   theme = "uikit_view_slider",
 *   display_types = {"normal"}
 * )
 */
class UIkitViewSlider extends StylePluginBase {

  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;


  /**
   * Does the Style plugin support grouping of rows?
   *
   * @var bool
   */
  protected $usesGrouping = FALSE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['image_field'] = ['default' => NULL];
    $options['title_field'] = ['default' => NULL];
    $options['caption_field'] = ['default' => NULL];
    $options['thumbnav_field'] = ['default' => NULL];
    $options['width_'] = ['default' => 'uk-child-width-1-1'];
    $options['width_@s'] = ['default' => 'uk-child-width-1-1@s'];
    $options['width_@m'] = ['default' => 'uk-child-width-1-2@m'];
    $options['width_@l'] = ['default' => 'uk-child-width-1-3@l'];
    $options['width_@xl'] = ['default' => 'uk-child-width-1-4@xl'];
    $options['grid_gutter'] = ['default' => NULL];
    $options['caption_background'] = ['default' => NULL];
    $options['caption_transition'] = ['default' => NULL];
    $options['caption_position'] = ['default' => 'uk-position-bottom'];
    $options['caption_modifier'] = ['default' => NULL];
    $options['caption_toggle'] = ['default' => FALSE];
    $options['slidenav'] = ['default' => TRUE];
    $options['slidenav_outside'] = ['default' => FALSE];
    $options['slidenav_big'] = ['default' => FALSE];
    $options['dotnav'] = ['default' => TRUE];
    $options['thumbnav'] = ['default' => FALSE];
    $options['light'] = ['default' => FALSE];
    $options['autoplay'] = ['default' => TRUE];
    $options['autoplay_interval'] = ['default' => 6000];
    $options['center'] = ['default' => FALSE];
    $options['finite'] = ['default' => FALSE];
    $options['index'] = ['default' => 0];
    $options['pause_on_hover'] = ['default' => TRUE];
    $options['sets'] = ['default' => FALSE];
    $options['velocity'] = ['default' => 1];
    $options['grid_match_height'] = ['default' => TRUE];
    $options['grid_match_height_selector'] = ['default' => NULL];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['field_mapping'] = [
      '#type' => 'details',
      '#title' => $this->t('Field mapping for images'),
      '#open' => TRUE,
    ];
    $form['field_mapping_legend'] = [
      '#type' => 'item',
      '#title' => $this->t('Field mapping'),
      '#description' => $this->t('You only have to worry about the "field mapping" section, if you are using fields and want to display images in the slider. If the image_field is empty, the slider will display the rendered entity or all the fields you have configured.'),
       '#fieldset' => 'field_mapping',
    ];
    $form['image_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Image field'),
      '#empty_option' => '- None -',
      '#options' => $this->displayHandler->getFieldLabels(),
      '#default_value' => $this->options['image_field'],
      '#description' => $this->t('Select the field to use as the slide image.'),
      '#fieldset' => 'field_mapping',
    ];
    $form['title_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Caption Title'),
      '#empty_option' => '- None -',
      '#options' => $this->displayHandler->getFieldLabels(),
      '#default_value' => $this->options['title_field'],
      '#description' => $this->t('Select the field to use as the slide title.'),
      '#fieldset' => 'field_mapping',
    ];
    $form['caption_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Caption text'),
      '#empty_option' => '- None -',
      '#options' => $this->displayHandler->getFieldLabels(),
      '#default_value' => $this->options['caption_field'],
      '#description' => $this->t('Select the field to use as the slide caption'),
      '#fieldset' => 'field_mapping',
    ];
    $form['thumbnav_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Thumbnav field'),
      '#empty_option' => '- None -',
      '#options' => $this->displayHandler->getFieldLabels(),
      '#default_value' => $this->options['thumbnav_field'],
      '#description' => $this->t('Select the image field to use as thumbnav navigation in slider'),
      '#fieldset' => 'field_mapping',
    ];
    $form['slider_options'] = [
      '#type' => 'details',
      '#title' => $this->t('Slider options'),
      '#open' => TRUE,
    ];
    // Grid options
    $args = [
      '@href' => 'https://getuikit.com/docs/grid',
      '@title' => 'Grid component - UIkit documentation',
    ];
    $breakpoints = [
      '' => $this->t('Affects all device widths'),
      '@s' => $this->t('Affects device widths of 640px and higher.'),
      '@m' => $this->t('Affects device widths of 960px and higher.'),
      '@l' => $this->t('Affects device widths of 1200px and higher.'),
      '@xl' => $this->t('Affects device widths of 1600px and higher.'),
    ];
    $form['grid_columns'] = [
      '#type' => 'item',
      '#title' => $this->t('Grid columns'),
      '#description' => $this->t("To create a grid whose child elements' widths are evenly split, we apply one class to the grid for each breakpoint. Each item in the grid is then automatically applied a width based on the number of columns selected for each breakpoint. See <a href='@href' target='_blank' title='@title'>Grid component</a> for more details.", $args),
       '#fieldset' => 'slider_options',
    ];
    foreach (['', '@s', '@m', '@l', '@xl'] as $size) {
      $form["width_${size}"] = [
        '#type' => 'select',
        '#title' => $this->t("uk-child-width-*${size}"),
        '#required' => TRUE,
        '#default_value' => $this->options["width_${size}"],
        '#options' => [
          "uk-child-width-1-1${size}" => 1,
          "uk-child-width-1-2${size}" => 2,
          "uk-child-width-1-3${size}" => 3,
          "uk-child-width-1-4${size}" => 4,
          "uk-child-width-1-5${size}" => 5,
          "uk-child-width-1-6${size}" => 6,
        ],
        '#description' => $breakpoints[$size],
        '#fieldset' => 'slider_options',
      ];
    }
    $form['grid_gutter'] = [
      '#type' => 'select',
      '#title' => $this->t('Grid gutter'),
      '#default_value' => $this->options['grid_gutter'],
      '#empty_option' => $this->t('Default gutter'),
      '#options' => [
        'uk-grid-small' => $this->t('Small gutter'),
        'uk-grid-medium' => $this->t('Medium gutter'),
        'uk-grid-large' => $this->t('Large gutter'),
        'uk-grid-collapse' => $this->t('Collapse gutter'),
      ],
      '#description' => $this->t('Grids automatically create a horizontal gutter between columns and a vertical one between two succeeding grids. By default, the grid gutter is wider on large screens.<br /><strong>Note</strong>: <em class="placeholder">Grid collapse</em> removes the grid gutter.'),
       '#fieldset' => 'slider_options',
    ];
    $form['caption_background'] = [
      '#type' => 'select',
      '#title' => $this->t('Overlay background for legend'),
      '#empty_option' => $this->t('-None-'),
      '#options' => [
        'uk-overlay-default' => $this->t('default'),
        'uk-overlay-primary' => $this->t('Primary'),
        'uk-overlay-secondary' => $this->t('Secondary'),
      ],
      '#default_value' => $this->options['caption_background'],
      '#fieldset' => 'slider_options',
    ];
     $form['caption_transition'] = [
      '#type' => 'select',
      '#title' => $this->t('Caption transition'),
      '#empty_option' => $this->t('-None-'),
      '#default_value' => $this->options['caption_transition'],
        '#options' => [
          'uk-transition-fade' => $this->t('fade'),
          'uk-transition-slide-top' => $this->t('slide from the top'),
          'uk-transition-slide-bottom' => $this->t('slide from the bottom'),
          'uk-transition-slide-left' => $this->t('slide from the left'),
          'uk-transition-slide-right' => $this->t('slide from the right '),
          'uk-transition-slide-top-small' => $this->t('slide from the top with a smaller distance'),
          'uk-transition-slide-bottom-small' => $this->t('slide from the bottom with a smaller distance'),
          'uk-transition-slide-left-small' => $this->t('slide from the left with a smaller distance'),
          'uk-transition-slide-right-small' => $this->t('slide from the right with a smaller distance'),
          'uk-transition-slide-top-medium' => $this->t('slide from the top  with a medium distance'),
          'uk-transition-slide-bottom-medium' => $this->t('slide from the bottom  with a medium distance'),
          'uk-transition-slide-left-medium' => $this->t('slide from the left  with a medium distance'),
          'uk-transition-slide-right-medium' => $this->t('slide from the right  with a medium distance'),
        ],
      '#description' => $this->t('Transition effect for the caption'),
      '#fieldset' => 'slider_options',
    ];
     $form['caption_position'] = [
      '#type' => 'select',
      '#title' => $this->t('Caption position'),
      '#default_value' => $this->options['caption_position'],
        '#options' => [
          'uk-position-top' => $this->t('Position element at the top'),
          'uk-position-top-left' => $this->t('Position element at the top left'),
          'uk-position-top-center' => $this->t('Position element at the top center'),
          'uk-position-top-right' => $this->t('Position element at the top right'),
          'uk-position-center' => $this->t('Position element vertically centered in the middle'),
          'uk-position-center-left' => $this->t('Position element vertically centered on the left'),
          'uk-position-center-right' => $this->t('Position element vertically centered on the right'),
          'uk-position-bottom' => $this->t('Position element at the bottom'),
          'uk-position-bottom-left' => $this->t('Position element at the bottom left'),
          'uk-position-bottom-center' => $this->t('Position element at the bottom center'),
          'uk-position-bottom-right' => $this->t('Position element at the bottom right'),
          'uk-position-left' => $this->t('Position element at the left'),
          'uk-position-right' => $this->t('Position element at the right'),
          'uk-position-cover' => $this->t('Position element to cover its container'),
        ],
      '#description' => $this->t('Position for the caption'),
      '#fieldset' => 'slider_options',
    ];
     $form['caption_modifier'] = [
      '#type' => 'select',
      '#title' => $this->t("Caption margin (modifier)"),
      '#empty_option' => $this->t('-None-'),
      '#default_value' => $this->options['caption_modifier'],
        '#options' => [
          'uk-position-small' => $this->t('Small'),
          'uk-position-medium' => $this->t('Medium'),
          'uk-position-large' => $this->t('Large'),
        ],
      '#description' => $this->t('Apply a margin to positioned caption'),
      '#fieldset' => 'slider_options',
    ];
    $form['caption_toggle'] = [
      '#title' => $this->t('Display Legend only on hover'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['caption_toggle'],
      '#fieldset' => 'slider_options',
    ];
    $form['slidenav'] = [
      '#title' => $this->t('Display slidenav buttons (next/previous)'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['slidenav'],
      '#fieldset' => 'slider_options',
    ];
    $form['slidenav_outside'] = [
      '#title' => $this->t('Display slidenav buttons outside slider'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['slidenav_outside'],
      '#fieldset' => 'slider_options',
    ];
    $form['slidenav_big'] = [
      '#title' => $this->t('increase the size of the slidenav icons'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['slidenav_big'],
      '#fieldset' => 'slider_options',
    ];
    $form['dotnav'] = [
      '#title' => $this->t('Display dotnav buttons (pager)'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['dotnav'],
      '#fieldset' => 'slider_options',
    ];
    $form['thumbnav'] = [
      '#title' => $this->t('Display thumbnav'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['thumbnav'],
      '#description' => $this->t('Add the .uk-light class to improve the visibility of objects on dark backgrounds in a light style. '),
      '#fieldset' => 'slider_options',
    ];
      $form['light'] = [
        '#title' => $this->t('Inverse component'),
        '#type' => 'checkbox',
        '#default_value' => $this->options['light'],
        '#fieldset' => 'slider_options',
      ];
    $form['autoplay'] = [
      '#title' => $this->t('Slider autoplays'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['autoplay'],
      '#fieldset' => 'slider_options',
    ];
    $form['autoplay_interval'] = [
      '#title' => $this->t('The delay between switching slides in autoplay mode'),
      '#type' => 'number',
      '#default_value' => $this->options['autoplay_interval'],
      '#min' => 3000,
      '#step' => 1000,
      '#fieldset' => 'slider_options',
    ];
    $form['center'] = [
      '#title' => $this->t('Center the active slide'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['center'],
      '#fieldset' => 'slider_options',
    ];
    $form['finite'] = [
      '#title' => $this->t('Disable infinite sliding'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['finite'],
      '#fieldset' => 'slider_options',
    ];
    $form['index'] = [
      '#title' => $this->t('Slider item to show. 0 based index'),
      '#type' => 'number',
      '#default_value' => $this->options['index'],
      '#fieldset' => 'slider_options',
    ];
    $form['pause_on_hover'] = [
      '#title' => $this->t('Pause autoplay mode on hover'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['pause_on_hover'],
      '#fieldset' => 'slider_options',
    ];
    $form['sets'] = [
      '#title' => $this->t('Slide in sets'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['sets'],
      '#fieldset' => 'slider_options',
    ];
    $form['velocity'] = [
      '#title' => $this->t('The animation velocity (pixel/ms)'),
      '#type' => 'number',
      '#default_value' => $this->options['velocity'],
      '#fieldset' => 'slider_options',
    ];
    $form['grid_match_height'] = [
      '#title' => $this->t('Grid Cell Match height'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['grid_match_height'],
      '#fieldset' => 'slider_options',
    ];
    $form['grid_match_height_selector'] = [
      '#title' => $this->t('The selector for match height (optional'),
      '#type' => 'textfield',
      '#default_value' => $this->options['grid_match_height_selector'],
      '#description' => $this->t('With "match height" setting checked, the direct child of each cell will have the same height.<br />If you want apply match height to another selector, use this field.'),
      '#fieldset' => 'slider_options',
    ];
  }
}
