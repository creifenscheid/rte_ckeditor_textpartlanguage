<?php

defined('TYPO3') || die();

$extensionKey = 'dummy_extension';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript', \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey) . ' :: MainTemplate');

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('seo')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript/XmlSitemaps', \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey) . ' :: XML-Sitemaps');
}