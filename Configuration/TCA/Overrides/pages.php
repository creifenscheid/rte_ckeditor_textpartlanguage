<?php

defined('TYPO3') || die();

$extensionKey = 'cke_textpartlanguage';
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TSConfig/RTE.tsconfig',
    'EXT:' . $extensionName . ' :: Add textpart language plugin'
);
