<?php
declare(strict_types=1);

defined('TYPO3_MODE') or die();

call_user_func(function () {
    $_LLL_be = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf';

    $pluginNames = [
        'Books' => [
            'subtypes_excludelist' => 'select_key',
        ],
        'TeaserBooks' => [
            'subtypes_excludelist' => 'select_key, pages, recursive',
        ],
    ];

    foreach ($pluginNames as $pluginName => $pluginConf) {
        $pluginSignature = 'cartbooks_' . strtolower($pluginName);
        $pluginNameSC = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($pluginName)));
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Extcode.cart_books',
            $pluginName,
            $_LLL_be . ':tx_cartbooks.plugin.' . $pluginNameSC . '.title'
        );

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = $pluginConf['subtypes_excludelist'];

        $flexFormPath = 'EXT:cart_books/Configuration/FlexForms/' . $pluginName . 'Plugin.xml';
        if (file_exists(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($flexFormPath))) {
            $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
                $pluginSignature,
                'FILE:' . $flexFormPath
            );
        }
    }
});
