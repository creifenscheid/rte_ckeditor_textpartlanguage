<?php

namespace CReifenscheid\RteCkeditorTextpartlanguage\EventListener;

use TYPO3\CMS\RteCKEditor\Form\Element\Event\BeforeGetExternalPluginsEvent;
use TYPO3\CMS\RteCKEditor\Form\Element\Event\BeforePrepareConfigurationForEditorEvent;

class RteConfigEnhancer
{
   public function afterPrepareConfiguration(AfterPrepareConfigurationForEditorEvent $event): void
   {
      $data = $event->getData();
      $configuration = $event->getConfiguration();
      $configuration['extraPlugins'][] = 'example_plugin';
      $event->setConfiguration($configuration);
      
      debug($data);
   }
}