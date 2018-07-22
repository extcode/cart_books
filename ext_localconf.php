<?php

defined('TYPO3_MODE') or die();

// configure plugins

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Extcode.' . $_EXTKEY,
    'Books',
    [
        'Book' => 'show, list, teaser',
    ],
    [
        'Book' => '',
    ]
);

// Icon Registry

if (TYPO3_MODE === 'BE') {
    $icons = [
        'icon-apps-pagetree-cartbooks-folder' => 'pagetree_cartbooks_folder.svg',
        'icon-apps-pagetree-cartbooks-page' => 'pagetree_cartbooks_page.svg',
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
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:cart_books/Configuration/TSconfig/ContentElementWizard.txt">
');

// Cart Hooks

if (TYPO3_MODE === 'FE') {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['CartBooks'] =
        \Extcode\CartBooks\Hooks\CartProductHook::class;
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
$GLOBALS['TYPO3_CONF_VARS']['EXT'][$_EXTKEY]['templateLayouts'][] = ['LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:flexforms_template.templateLayout.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT'][$_EXTKEY]['templateLayouts'][] = ['LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:flexforms_template.templateLayout.grid', 'grid'];
