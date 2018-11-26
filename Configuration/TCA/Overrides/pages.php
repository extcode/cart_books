<?php
declare(strict_types=1);

defined('TYPO3_MODE') or die();

call_user_func(function () {
    $_LLL_be = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:';

    $GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
        $_LLL_be . 'pages.doktype.188',
        188,
        'apps-pagetree-page-cartbooks-book',
    ];
    $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
        $_LLL_be . 'tcarecords-pages-contains.cart_books',
        'cartbooks',
        'apps-pagetree-folder-cartbooks-books',
    ];

    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][188] = 'apps-pagetree-page-cartbooks-book';
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-cartbooks'] = 'apps-pagetree-folder-cartbooks-books';
});
