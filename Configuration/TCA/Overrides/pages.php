<?php

defined('TYPO3') || die();

$extensionKey = 'dummy_extension';
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TSConfig/Page.tsconfig',
    'EXT:' . $extensionName . ' :: Main page tsconfig'
);
