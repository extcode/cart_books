<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$_LLL_db = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_db.xlf';

$newSysCategoryColumns = [
    'cart_book_list_pid' => [
        'exclude' => 1,
        'label' => $_LLL_db . ':tx_cartbooks_domain_model_category.cart_book_list_pid',
        'config' => [
            'type' => 'group',
            'allowed' => 'pages',
            'size' => 1,
            'maxitems' => 1,
            'minitems' => 0,
            'default' => 0,
            'suggestOptions' => [
                'default' => [
                    'searchWholePhrase' => true,
                ],
            ],
        ],
    ],
    'cart_book_show_pid' => [
        'exclude' => 1,
        'label' => $_LLL_db . ':tx_cartbooks_domain_model_category.cart_book_show_pid',
        'config' => [
            'type' => 'group',
            'allowed' => 'pages',
            'size' => 1,
            'maxitems' => 1,
            'minitems' => 0,
            'default' => 0,
            'suggestOptions' => [
                'default' => [
                    'searchWholePhrase' => true,
                ],
            ],
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('sys_category', $newSysCategoryColumns);
ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    'cart_book_list_pid, cart_book_show_pid',
    '',
    'after:description'
);
