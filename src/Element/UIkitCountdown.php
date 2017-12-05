<?php

namespace Drupal\uikit_components\Element;

use Drupal\Core\Render\Element\RenderElement;

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
    return [
      '#expire_date' => NULL,
      '#separators' => NULL,
      '#labels' => NULL,
      '#theme_wrappers' => ['uikit_countdown'],
    ];
  }

}
