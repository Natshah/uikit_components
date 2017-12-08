<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Template\Attribute;

/**
 * Provides a render element for the Countdown component.
 *
 * Properties:
 * - #expire_date: The date when the countdown should expire using the ISO
 *   8601 format, e.g. 2017-12-04T22:00:00+00:00 (UTC time).
 * - #separators: An associative array to insert a separator between each
 *   number, containing:
 *   - days_hours: The separator to insert between the days and hours.
 *   - hours_minutes: The separator to insert between hours and minutes.
 *   - minutes_seconds: The separator to insert between minutes and seconds.
 * - #labels: An associative array for labels to display below each number,
 *   containing:
 *   - days: The label to display for days.
 *   - hours: The label to display for hours.
 *   - minutes: The label to display for minutes.
 *   - seconds: The label to display for seconds.
 *
 * Usage example:
 * @code
 * $build['countdown'] = [
 *   '#type' => 'uikit_countdown',
 *   '#expire_date' => date('c', strtotime('+1 day', time())),
 *   '#separators' => [
 *     'days_hours' => ':',
 *     'hours_minutes' => ':',
 *     'minutes_seconds' => ':',
 *   ],
 *   '#labels' => [
 *     'days' => t('Days'),
 *     'hours' => t('Hours'),
 *     'minutes' => t('Minutes'),
 *     'seconds' => t('Seconds'),
 *   ],
 * ];
 * @endcode
 *
 * @see template_preprocess_uikit_countdown()
 * @see https://getuikit.com/docs/countdown
 *
 * @ingroup uikit_components_theme_render
 *
 * @RenderElement("uikit_countdown")
 */
class UIkitCountdown extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#expire_date' => NULL,
      '#separators' => NULL,
      '#labels' => NULL,
      '#attributes' => new Attribute(),
      '#pre_render' => [
        [$class, 'preRenderUIkitCountdown'],
      ],
      '#theme_wrappers' => ['uikit_countdown'],
    ];
  }

  /**
   * Pre-render callback: Sets the countdown attributes.
   *
   * Doing so during pre_render gives modules a chance to alter the countdown.
   *
   * @param array $element
   *   A renderable array.
   *
   * @return array
   *   A renderable array.
   */
  public static function preRenderUIkitCountdown($element) {
    // Get the expire date.
    $date = $element['#expire_date'];

    // Set the attributes for the countdown outer element.
    $element['#attributes']->addClass('uk-grid-small');
    $element['#attributes']->addClass('uk-child-width-auto');
    $element['#attributes']->setAttribute('uk-grid', '');
    $element['#attributes']->setAttribute('uk-countdown', "date: $date");

    return $element;
  }

}
