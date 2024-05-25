<?php

declare(strict_types=1);

namespace Drupal\html5_audio\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'HTML5 Audio' formatter.
 *
 * @FieldFormatter(
 *   id = "html5_audio_formatter",
 *   label = @Translation("HTML5 Audio"),
 *   field_types = {"link"},
 * )
 */
final class Html5AudioFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  // Using the parent service to inject the default settings
  public static function defaultSettings() {
    return [
      'autoplay' => '0',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  // setting the autoplay settings form fuctions
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['autoplay'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('autoplay enabled'),
      '#default_value' => $this->getSetting('autoplay'),
    ];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  // setting up the settings summary to work with autoplay
  public function settingsSummary() {
    $summary=[];
    $settings =$this->getSettings();
    // summary logic
    if ($settings['autoplay']){
      $summary[] = $this->t('Autoplay is now enabled.')->render();
    }
    else {
      $summary[] = $this->t('Autoplay is disabled.')->render();
    }
    return $summary;
  }

  /**
  * {@inheritdoc}
  */
  public function viewElements(FieldItemListInterface  $items, $langcode) {
    $element = [];

    // Render all field values as part of a single <audio> tag.
    $sources = [];
    foreach ($items as $item) {
      // Get the mime type. mime type guesser  https://api.drupal.org/api/drupal/core%21core.services.yml/service/file.mime_type.guesser/10.
      $mimetype = \Drupal::service('file.mime_type.guesser')->guessMimeType(  $item->uri);
      $sources[] = [
        'src' => $item->uri,
        'mimetype' => $mimetype,
      ];
   }
    // Auto Play Config
    $autoplay = '';
    if ($this->getSetting('autoplay')) {
      $autoplay = 'autoplay';
    }
   // This is an array for theming.
    $element[] = [
      '#theme' => 'audio_tag',
      '#sources' => $sources,
    ];

   return $element;
  }

}
