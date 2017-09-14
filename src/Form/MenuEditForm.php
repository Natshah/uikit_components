<?php

namespace Drupal\uikit_components\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\menu_ui\MenuForm;
use Drupal\uikit_components\UIkitComponents;

/**
 * Base form for menu edit forms.
 */
class MenuEditForm extends MenuForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $t_args = [
      ':accordion' => UIkitComponents::getComponentURL('accordion'),
      ':list' => UIkitComponents::getComponentURL('list'),
      ':nav' => UIkitComponents::getComponentURL('nav'),
      ':subnav' => UIkitComponents::getComponentURL('subnav'),
    ];

    $description_links = [
      $this->t('<a href=":accordion" target="_blank">Accordion</a>', $t_args),
      $this->t('<a href=":list" target="_blank">List</a>', $t_args),
      $this->t('<a href=":nav" target="_blank">Nav</a>', $t_args),
      $this->t('<a href=":subnav" target="_blank">Subnav</a>', $t_args),
    ];
    $links = [
      '#markup' => implode(', ', $description_links)
    ];

    $form['label']['#weight'] = -10;
    $form['id']['#weight'] = -9;
    $form['description']['#weight'] = -8;

    $form['menu_style'] = [
      '#type' => 'select',
      '#title' => $this->t('UIkit menu style'),
      '#description' => $this->t('<p>Select the UIkit component to set a default style for the menu. Some options will provide additional settings. Examples: @examples</p>', ['@examples' => render($links)]),
      '#options' => [
        'uk-accordion' => $this->t('Accordion'),
        $this->t('List')->render() => [
          'uk-list' => $this->t('Default list'),
          'uk-list-bullet' => $this->t('Bullet list'),
          'uk-list-divider' => $this->t('Divided list'),
          'uk-list-striped' => $this->t('Striped list'),
        ],
        'uk-nav' => $this->t('Nav'),
        $this->t('Subnav')->render() => [
          'uk-subnav' => $this->t('Default subnav'),
          'uk-subnav-divider' => $this->t('Divided subnav'),
          'uk-subnav-pill' => $this->t('Pill subnav'),
        ],
      ],
      '#empty_value' => '',
      '#default_value' => UIkitComponents::getMenuStyle($this->entity->id()),
      '#weight' => -7,
    ];

    $form['menu_style_list_large'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Large modifier'),
      '#description' => $this->t('Check to increase the spacing between list items.'),
      '#default_value' => UIkitComponents::getLargeList($this->entity->id()),
      '#weight' => -6,
      '#states' => array(
        'visible' => [
          [':input[name="menu_style"]' => ['value' => 'uk-list']],
          'or',
          [':input[name="menu_style"]' => ['value' => 'uk-list-bullet']],
          'or',
          [':input[name="menu_style"]' => ['value' => 'uk-list-divider']],
          'or',
          [':input[name="menu_style"]' => ['value' => 'uk-list-striped']],
        ],
      ),
    ];

    $form['menu_style_nav_style_modifiers'] = [
      '#type' => 'select',
      '#title' => $this->t('Nav style modifiers'),
      '#description' => $this->t('Select which nav style to use.'),
      '#options' => [
        'uk-nav-default' => $this->t('Default'),
        'uk-nav-primary' => $this->t('Primary'),
      ],
      '#empty_value' => '',
      '#default_value' => UIkitComponents::getNavStyleModifier($this->entity->id()),
      '#weight' => -5,
      '#states' => array(
        'visible' => [
          [':input[name="menu_style"]' => ['value' => 'uk-nav']],
        ],
      ),
    ];

    $form['menu_style_nav_center_modifier'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Nav center modifier'),
      '#description' => $this->t('Select to center nav items.'),
      '#default_value' => UIkitComponents::getNavCenterModifier($this->entity->id()),
      '#weight' => -4,
      '#states' => array(
        'visible' => [
          [':input[name="menu_style"]' => ['value' => 'uk-nav']],
        ],
      ),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    UIkitComponents::setMenuStyle($this->entity->id(), $form_state->getValue('menu_style'));
    UIkitComponents::setLargeList($this->entity->id(), $form_state->getValue('menu_style_list_large'));
    UIkitComponents::setNavStyleModifier($this->entity->id(), $form_state->getValue('menu_style_nav_style_modifiers'));
    UIkitComponents::setNavCenterModifier($this->entity->id(), $form_state->getValue('menu_style_nav_center_modifier'));
  }

}
