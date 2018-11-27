<?php

defined('TYPO3_MODE') or die();

$_LLL_be = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:';

// configure plugins

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Extcode.cart_books',
    'Books',
    [
        'Book' => 'show, list',
    ],
    [
        'Book' => '',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Extcode.cart_books',
    'TeaserBooks',
    [
        'Book' => 'teaser',
    ],
    [
        'Book' => '',
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

// Cart Hooks

if (TYPO3_MODE === 'FE') {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['CartBooks']['Cart']['AddToCartFinisher'] =
        \Extcode\CartBooks\Domain\Finisher\Cart\AddToCartFinisher::class;
}

// realurl Hook

if (TYPO3_MODE === 'FE') {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['ConfigurationReader_postProc'][1520842411] =
        'EXT:cart_books/Classes/Hooks/RealUrlHook.php:Extcode\CartBooks\Hooks\RealUrlHook->postProcessConfiguration';
}

// clearCachePostProc Hook

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['cartbooks_clearcache'] =
    \Extcode\CartBooks\Hooks\DataHandler::class . '->clearCachePostProc';

// Signal Slots

$dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
);

$dispatcher->connect(
    \Extcode\Cart\Utility\StockUtility::class,
    'handleStock',
    \Extcode\CartBooks\Utility\StockUtility::class,
    'handleStock'
);

// register "cartbooks:" namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['cartbooks'][]
    = 'Extcode\\CartBooks\\ViewHelpers';

// register listTemplateLayouts
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid', 'grid'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['teaser_books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_books']['templateLayouts']['teaser_books'][] = [$_LLL_be . 'flexforms_template.templateLayout.books.grid', 'grid'];
