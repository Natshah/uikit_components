<?php

/**
 * @file
 * Modify structured content arrays.
 *
 * These hooks are called after the content has been assembled in a structured
 * array and may be used for doing processing which requires that the complete
 * content structure has been built.
 *
 * If the theme wishes to act on the rendered HTML of the content rather than
 * the structured content array, it may use this hook to add a #post_render
 * callback. Alternatively, it could also implement hook_preprocess_HOOK().
 *
 * @see \Drupal\Core\Render\RendererInterface
 * @see \Drupal\Core\Render\Renderer
 */

use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\uikit_components\UIkitComponents;

/**
 * Implements hook_theme_suggestions_HOOK_alter().
 */
function uikit_components_theme_suggestions_menu_alter(array &$suggestions, array $variables) {
  $menu_name = isset($variables['menu_name']) ? $variables['menu_name'] : FALSE;
  $config = \Drupal::config('uikit_components.settings');

  if ($menu_name && $config->get('additional_menu_styles')) {
    $menu_style = UIkitComponents::getMenuStyle($menu_name);

    if ($menu_style) {
      switch ($menu_style) {
        case 'uk-list':
        case 'uk-list-bullet':
        case 'uk-list-divider':
        case 'uk-list-striped':
        case 'uk-subnav':
        case 'uk-subnav-divider':
        case 'uk-subnav-pill':
          $suggestions[] = 'menu__uk_menu';
          break;

        case 'uk-nav':
          $suggestions[] = 'menu__uk_nav';
          break;
      }
    }
    elseif ($menu_name != 'admin' && $menu_name != 'devel') {
      $suggestions[] = 'menu__default';
    }
  }
}

/**
 * Implements hook_entity_type_alter().
 */
function uikit_components_entity_type_alter(array &$entity_types) {
  $config = \Drupal::config('uikit_components.settings');

  if ($config->get('additional_menu_styles')) {
    // Replace form class for menu add/edit forms with our own form class.
    /** @var $entity_types \Drupal\Core\Entity\EntityTypeInterface[] */
    $entity_types['menu']
      ->setFormClass('add', 'Drupal\uikit_components\Form\MenuEditForm')
      ->setFormClass('edit', 'Drupal\uikit_components\Form\MenuEditForm');
  }
}

/**
 * Implements hook_form_BASE_FORM_ID_alter().
 */
function uikit_components_form_menu_link_content_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  $menu_link = $form_state->getFormObject()->getEntity();
  $menu_link_options = $menu_link->link->first()->options ?: [];

  // Translatable string arguments.
  $t_args = [
    ':navbar' => Url::fromUri('https://getuikit.com/v2/docs/navbar.html')->toString(),
  ];

  // UIkit navbar component options.
  $form['menu_item_type'] = [
    '#type' => 'select',
    '#title' => t('Menu item type'),
    '#default_value' => !empty($menu_link_options['menu_item_type']) ? $menu_link_options['menu_item_type'] : 0,
    '#options' => [
      0 => t('Normal menu item'),
      'nav_header' => t('Navigation header'),
      'nav_divider' => t('Navigation divider'),
    ],
    '#description' => t('Select the type of menu item this is. <em class="placeholder">Navigation header</em> and <em class="placeholder">Navigation divider</em> are special menu items from the <a href=":navbar" target="_blank">UIkit navbar component</a>.', $t_args),
  ];

  $form['actions']['submit']['#submit'][] = 'uikit_components_menu_link_content_form_submit';
}

/**
 * Process handler for the menu link content form.
 *
 * @param array $form
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 */
function uikit_components_menu_link_content_form_submit($form, FormStateInterface $form_state) {
  $menu_item_type = $form_state->getValue('menu_item_type');
  $type = empty($menu_item_type) ? 'normal_menu_item' : $menu_item_type;

  $options = [
    'menu_item_type' => $type,
  ];

  $menu_link = $form_state->getFormObject()->getEntity();
  $menu_link_options = $menu_link->link->first()->options;

  $merged = array_merge($menu_link_options, $options);

  $menu_link->link->first()->options = $merged;
  $menu_link->save();
}

/**
 * Implements hook_form_BASE_FORM_ID_alter().
 */
function uikit_components_form_block_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  $block = $form_state->getFormObject()->getEntity();
  $region = $block->getRegion();

  if ($region == 'navbar') {
    // Add navbar alignment setting to navbar blocks.
    $form['uikit_navbar_alignment'] = [
      '#type' => 'select',
      '#title' => t('UIkit navbar alignment'),
      '#default_value' => $block->getThirdPartySetting('uikit_components', 'uikit_navbar_alignment'),
      '#options' => [
        'left' => t('Left'),
        'center' => t('Center'),
        'right' => t('Right'),
      ],
      '#description' => t('Select the alignment of this menu in the UIkit navbar region.'),
      '#weight' => 0,
    ];

    // Add a form entity builder.
    $form['#entity_builders'][] = 'uikit_components_form_block_form_builder';
  }
}

/**
 * Entity builder for the block configuration entity.
 */
function uikit_components_form_block_form_builder($entity_type, Drupal\block\Entity\Block $block, &$form, \Drupal\Core\Form\FormStateInterface $form_state) {
  if ($form_state->getValue('uikit_navbar_alignment')) {
    $block->setThirdPartySetting('uikit_components', 'uikit_navbar_alignment', $form_state->getValue('uikit_navbar_alignment'));
  }
}
