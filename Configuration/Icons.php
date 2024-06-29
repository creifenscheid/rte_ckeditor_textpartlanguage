<?php

$extensionKey = 'dummy_extension';
$iconNamespace = str_replace('_', '', $extensionKey);

return [
    $iconNamespace . '-extension' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:' . $extensionKey . '/Resources/Public/Icons/Extension.svg'
    ],
    $iconNamespace . '-plugin-pluginname' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:' . $extensionKey . '/Resources/Public/Icons/Extension.svg'
    ],
];
