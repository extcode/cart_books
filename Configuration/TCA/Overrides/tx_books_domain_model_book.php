<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$_LLL_cart = 'LLL:EXT:cart/Resources/Private/Language/locallang_db.xlf';
$_LLL_db = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_db.xlf';
$_LLL_tca = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_tca.xlf';

$newColumns = [
    'sku' => [
        'exclude' => 1,
        'label' => $_LLL_db . ':tx_books_domain_model_book.sku',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
            'required' => true,
        ],
    ],

    'price' => [
        'exclude' => 1,
        'label' => $_LLL_db . ':tx_books_domain_model_book.price',
        'config' => [
            'type' => 'number',
            'size' => 30,
            'default' => '0.00',
            'required' => true,
            'format' => 'decimal',
        ],
    ],
    'special_prices' => [
        'exclude' => 1,
        'label' => $_LLL_db . ':tx_books_domain_model_book.special_prices',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_cartbooks_domain_model_specialprice',
            'foreign_field' => 'book',
            'foreign_table_where' => ' AND tx_cartbooks_domain_model_specialprice.pid=###CURRENT_PID### ',
            'foreign_default_sortby' => 'price ASC',
            'maxitems' => 99,
            'appearance' => [
                'collapseAll' => 1,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1,
            ],
        ],
    ],
    'tax_class_id' => [
        'exclude' => 1,
        'label' => $_LLL_cart . ':tx_cart.tax_class_id',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => $_LLL_cart . ':tx_cart.tax_class_id.1', 'value' => 1],
                ['label' => $_LLL_cart . ':tx_cart.tax_class_id.2', 'value' => 2],
                ['label' => $_LLL_cart . ':tx_cart.tax_class_id.3', 'value' => 3],
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
        ],
    ],

    'handle_stock' => [
        'exclude' => 1,
        'label' => $_LLL_db . ':tx_books_domain_model_book.handle_stock',
        'config' => [
            'type' => 'check',
        ],
    ],
    'stock' => [
        'exclude' => 1,
        'displayCond' => 'FIELD:handle_stock:=:1',
        'label' => $_LLL_db . ':tx_books_domain_model_book.stock',
        'config' => [
            'type' => 'number',
            'size' => 30,
            'default' => 0,
        ],
    ],

    'tags' => [
        'exclude' => 1,
        'label' => $_LLL_db . ':tx_books_domain_model_book.tags',
        'config' => [
            'type' => 'group',
            'allowed' => 'tx_cart_domain_model_tag',
            'foreign_table' => 'tx_cart_domain_model_tag',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 100,
            'MM' => 'tx_cartbooks_domain_model_book_tag_mm',
            'suggestOptions' => [
                'default' => [
                    'searchWholePhrase' => true,
                ],
            ],
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('tx_books_domain_model_book', $newColumns);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_books_domain_model_book',
    'sku',
    '',
    'before:title'
);

ExtensionManagementUtility::addFieldsToPalette(
    'tx_books_domain_model_book',
    'prices',
    'price, tax_class_id, --linebreak--, special_prices'
);

ExtensionManagementUtility::addFieldsToPalette(
    'tx_books_domain_model_book',
    'stock',
    'handle_stock, stock'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_books_domain_model_book',
    '--div--;' . $_LLL_tca . ':tx_books_domain_model_book.div.price_and_stock,'
    . '--palette--;' . $_LLL_tca . ':tx_books_domain_model_book.palette.prices;prices,'
    . '--palette--;' . $_LLL_tca . ':tx_books_domain_model_book.palette.prices;stock,',
    '',
    'after:files'
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_books_domain_model_book',
    'tags',
    '',
    'before:category'
);
