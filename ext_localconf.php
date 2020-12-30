<?php

defined('TYPO3_MODE') or die();

$_LLL_be = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:';

// configure plugins

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'cart_books',
    'Books',
    [
        \Extcode\CartBooks\Controller\BookController::class => 'show, list',
    ],
    [
        \Extcode\CartBooks\Controller\BookController::class => '',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'cart_books',
    'TeaserBooks',
    [
        \Extcode\CartBooks\Controller\BookController::class => 'teaser',
    ],
    [
        \Extcode\CartBooks\Controller\BookController::class => '',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'cart_books',
    'SingleBook',
    [
        \Extcode\CartBooks\Controller\BookController::class => 'show',
    ],
    [
        \Extcode\CartBooks\Controller\BookController::class => '',
    ]
);

// Icon Registry

if (TYPO3_MODE === 'BE') {
    $icons = [
        'apps-pagetree-folder-cartbooks-books' => 'apps_pagetree_folder_cartbooks_books.svg',
        'apps-pagetree-page-cartbooks-book' => 'apps_pagetree_page_cartbooks_books.svg',
        'ext-cartbooks-wizard-icon' => 'cartbooks_plugin_wizard.svg',
    ];

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );

    foreach ($icons as $identifier => $fileName) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            [
                'source' => 'EXT:cart_books/Resources/Public/Icons/' . $fileName,
            ]
        );
    }
}

// TSconfig

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:cart_books/Configuration/TSconfig/ContentElementWizard.tsconfig">
');

// ke_search Hook - register indexer for books

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] =
    \Extcode\CartBooks\Hooks\KeSearchIndexer::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] =
    \Extcode\CartBooks\Hooks\KeSearchIndexer::class;

// clearCachePostProc Hook

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['cartbooks_clearcache'] =
    \Extcode\CartBooks\Hooks\DataHandler::class . '->clearCachePostProc';

// register "cartbooks:" namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['cartbooks'][]
    = 'Extcode\\CartBooks\\ViewHelpers';

// update wizard for slugs
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['cartBooksSlugUpdater'] =
    \Extcode\CartBooks\Updates\SlugUpdater::class;

// register listTemplateLayouts
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid1', 'grid1'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid3', 'grid3'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['teaser_books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['teaser_books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid1', 'grid1'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['teaser_books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid3', 'grid3'];
