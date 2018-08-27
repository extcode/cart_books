<?php

defined('TYPO3_MODE') or die();

$iconPath = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/';

$_LLL = 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript',
    'Shopping Cart - Cart Books'
);

/**
 * Register Frontend Plugins
 */
$pluginNames = [
    'Books' => [
        'subtypes_excludelist' => 'select_key'
    ],
    'TeaserBooks' => [
        'subtypes_excludelist' => 'select_key, pages, recursive'
    ],
];

foreach ($pluginNames as $pluginName => $pluginConf) {
    $pluginSignature = strtolower(str_replace('_', '', $_EXTKEY)) . '_' . strtolower($pluginName);
    $pluginNameSC = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($pluginName)));
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'Extcode.' . $_EXTKEY,
        $pluginName,
        $_LLL . ':tx_cartbooks.plugin.' . $pluginNameSC . '.title'
    );
    $TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = $pluginConf['subtypes_excludelist'];

    $flexFormPath = 'EXT:' . $_EXTKEY . '/Configuration/FlexForms/' . $pluginName . 'Plugin.xml';
    if (file_exists(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($flexFormPath))) {
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:' . $flexFormPath
        );
    }
}

$TCA['pages']['ctrl']['typeicon_classes']['contains-cartbooks'] = 'apps-pagetree-folder-cartbooks-books';

$TCA['pages']['columns']['module']['config']['items'][] = [
    'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf:tcarecords-pages-contains.cart_books',
    'cartbooks',
    'apps-pagetree-folder-cartbooks-books',
];
