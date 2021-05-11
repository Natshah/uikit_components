<?php

namespace Drupal\uikit_views\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render each item in a UIkit Slideshow component.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "uikit_view_slideshow",
 *   title = @Translation("UIkit Slideshow"),
 *   help = @Translation("Displays rows in a UIkit Slideshow component"),
 *   theme = "uikit_view_slideshow",
 *   display_types = {"normal"}
 * )
 */
class UIkitViewSlideshow extends StylePluginBase {

  /**
   * Does the style plugin for itself support to add fields to it's output.
   *
   * @var bool
   */
  protected $usesFields = TRUE;

  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['image_field'] = ['default' => NULL];
    $options['title_field'] = ['default' => NULL];
    $options['caption_field'] = ['default' => NULL];
    $options['thumbnav_field'] = ['default' => NULL];
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
    $options['animation'] = ['default' => 'slide'];
    $options['autoplay'] = ['default' => TRUE];
    $options['autoplay_interval'] = ['default' => 6000];
    $options['finite'] = ['default' => FALSE];
    $options['pause_on_hover'] = ['default' => TRUE];
    $options['index'] = ['default' => 0];
    $options['velocity'] = ['default' => 1];
    $options['ratio'] = ['default' => '16:9'];
    $options['min-height'] = ['default' => FALSE];
    $options['max-height'] = ['default' => FALSE];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    if (isset($form['grouping'])) {
      unset($form['grouping']);

      $form['field_mapping'] = [
        '#type' => 'details',
        '#title' => $this->t('Field mapping for images'),
        '#open' => TRUE,
      ];
      $form['image_field'] = [
        '#type' => 'select',
        '#title' => $this->t('Image field'),
        '#empty_option' => '- None -',
        '#required' => TRUE,
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
        '#title' => $this->t('Slideshow options'),
        '#open' => TRUE,
      ];
      $form['animation'] = [
        '#title' => t('Slideshow animation mode'),
        '#type' => 'select',
        '#default_value' => $this->options['animation'],
        '#options' => array(
          'slide' => $this->t('slide'),
          'fade' => $this->t('fade'),
          'scale' => $this->t('scale'),
          'pull' => $this->t('pull'),
          'push' => $this->t('push'),
        ),
        '#fieldset' => 'slider_options',
      ];
      $form['autoplay'] = [
        '#title' => $this->t('Slideshow autoplays'),
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
      $form['finite'] = [
        '#title' => $this->t('Disable infinite sliding'),
        '#type' => 'checkbox',
        '#default_value' => $this->options['finite'],
        '#fieldset' => 'slider_options',
      ];
      $form['pause_on_hover'] = [
        '#title' => $this->t('Pause autoplay mode on hover'),
        '#type' => 'checkbox',
        '#default_value' => $this->options['pause_on_hover'],
        '#fieldset' => 'slider_options',
      ];
      $form['index'] = [
        '#title' => $this->t('Slideshow item to show. 0 based index'),
        '#type' => 'number',
        '#default_value' => $this->options['index'],
        '#fieldset' => 'slider_options',
      ];
      $form['velocity'] = [
        '#title' => $this->t('The animation velocity (pixel/ms)'),
        '#type' => 'number',
        '#default_value' => $this->options['velocity'],
        '#fieldset' => 'slider_options',
      ];
      $form['ratio'] = [
        '#title' => $this->t('The ratio. (let this field blank to prevent height adjustment)'),
        '#type' => 'textfield',
        '#default_value' => $this->options['ratio'],
        '#fieldset' => 'slider_options',
      ];
      $form['min_height'] = [
        '#title' => $this->t('The minimum height (let this field blank to respect ratio)'),
        '#type' => 'number',
        '#default_value' => $this->options['min_height'],
        '#fieldset' => 'slider_options',
      ];
      $form['max_height'] = [
        '#title' => $this->t('The maximum height (let this field blank to respect ratio)'),
        '#type' => 'number',
        '#default_value' => $this->options['max_height'],
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
        '#default_value' => $this->options['slidenav'],
        '#fieldset' => 'slider_options',
      ];
      $form['thumbnav'] = [
        '#title' => $this->t('Display thumbnav'),
        '#type' => 'checkbox',
        '#default_value' => $this->options['thumbnav'],
        '#fieldset' => 'slider_options',
      ];
      $form['light'] = [
        '#title' => $this->t('Inverse component'),
        '#type' => 'checkbox',
        '#default_value' => $this->options['light'],
        '#description' => $this->t('Add the .uk-light class to improve the visibility of objects on dark backgrounds in a light style. '),
        '#fieldset' => 'slider_options',
      ];
    }
  }
}
