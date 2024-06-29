<?php

defined('TYPO3') || die();

(static function ($extensionKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey),
        'Pluginname',
        [
            \CReifenscheid\DummyExtension\Controller\ControllerNameController::class => 'list, show'
        ]
    );
})('dummy_extension');
