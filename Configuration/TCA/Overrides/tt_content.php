<?php

defined('TYPO3') || die();

$extensionKey = 'dummy_extension';
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey);

$plugins = [
    'PluginName' => [
        'icon' => 'dummyextension-plugin-pluginname',
        'flexform' => true,
    ],
];

foreach ($plugins as $pluginIdentifier => $pluginConfig) {
    $pluginSignature = strtolower($extensionName) . '_' . strtolower($pluginIdentifier);

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $extensionName,
        $pluginIdentifier,
        'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/Plugins/locallang.xlf:' . strtolower($pluginIdentifier) . '.label',
        $pluginConfig['icon'],
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,frame_class,space_before_class,space_after_class,sectionIndex,linkToTop,pages,recursive';

    // FlexForm configuration
    if (array_key_exists('flexform', $pluginConfig) && $pluginConfig['flexform'] === true) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/' . $pluginIdentifier . 'FlexForm.xml');
    }
}
