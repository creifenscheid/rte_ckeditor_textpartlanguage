<?php

$extensionKey = 'dummy_extension';

return [
    'imports' => [
        '@creifenscheid/' . str_replace('_', '-', $extensionKey) . '/' => 'EXT:' . $extensionKey . '/Resources/Public/JavaScript/',
    ],
];
