<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2024 Christian Reifenscheid
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'CKEditor 5 - Text part language',
    'description' => 'This extension implements the text part language feature for CKEditor 5',
    'category' => 'be',
    'author' => 'Christian Reifenscheid',
    'version' => '12.1.0',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'rte_ckeditor' => '12.4.0-12.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'CReifenscheid\\RteCkeditorTextpartlanguage\\' => 'Classes',
        ],
    ],
];
