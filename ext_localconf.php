<?php

use Extcode\CartBooks\Controller\BookController;
use Extcode\CartBooks\Hooks\DataHandler;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$_LLL_be = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:';

// configure plugins

ExtensionUtility::configurePlugin(
    'cart_books',
    'Books',
    [
        BookController::class => 'show, list',
    ],
    [
        BookController::class => '',
    ]
);

ExtensionUtility::configurePlugin(
    'cart_books',
    'TeaserBooks',
    [
        BookController::class => 'teaser',
    ],
    [
        BookController::class => '',
    ]
);

ExtensionUtility::configurePlugin(
    'cart_books',
    'SingleBook',
    [
        BookController::class => 'show',
    ],
    [
        BookController::class => '',
    ]
);

// TSconfig

ExtensionManagementUtility::addPageTSConfig('
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:cart_books/Configuration/TSconfig/ContentElementWizard.tsconfig">
');

// clearCachePostProc Hook

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['cartbooks_clearcache'] =
    DataHandler::class . '->clearCachePostProc';

// register "cartbooks:" namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['cartbooks'][]
    = 'Extcode\\CartBooks\\ViewHelpers';

// register listTemplateLayouts
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid1', 'grid1'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid3', 'grid3'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['teaser_books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['teaser_books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid1', 'grid1'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['teaser_books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid3', 'grid3'];
