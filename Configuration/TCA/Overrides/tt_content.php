<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

call_user_func(function () {
    $_LLL_be = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf';

    $pluginNames = [
        'Books' => [
            'subtypes_excludelist' => 'select_key',
        ],
        'SingleBook' => [
            'subtypes_excludelist' => 'select_key, pages, recursive',
        ],
        'TeaserBooks' => [
            'subtypes_excludelist' => 'select_key, pages, recursive',
        ],
    ];

    foreach ($pluginNames as $pluginName => $pluginConf) {
        $pluginSignature = 'cartbooks_' . strtolower($pluginName);
        $pluginNameSC = strtolower((string)preg_replace('/[A-Z]/', '_$0', lcfirst($pluginName)));
        ExtensionUtility::registerPlugin(
            'cart_books',
            $pluginName,
            $_LLL_be . ':tx_cartbooks.plugin.' . $pluginNameSC . '.title'
        );

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = $pluginConf['subtypes_excludelist'];

        $flexFormPath = 'EXT:cart_books/Configuration/FlexForms/' . $pluginName . 'Plugin.xml';
        if (file_exists(GeneralUtility::getFileAbsFileName($flexFormPath))) {
            $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
            ExtensionManagementUtility::addPiFlexFormValue(
                $pluginSignature,
                'FILE:' . $flexFormPath
            );
        }
    }
});
