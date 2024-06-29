<?php

defined('TYPO3') || die();

(static function ($extensionKey) {
    
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['ckeTextpartlanguage'] = 'EXT:' . $extensionKey . '/Configuration/RTE/Configuration.yaml';
    
})('cke_textpartlanguage');
