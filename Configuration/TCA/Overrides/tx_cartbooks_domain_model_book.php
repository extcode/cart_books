<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$_LLL_db = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_db.xlf';

$GLOBALS['TCA']['tx_cartbooks_domain_model_book']['category']['config']['maxitems'] = 1;

// category restriction based on settings in extension manager
$categoryRestrictionSetting = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('cart_books', 'categoryRestriction');

if ($categoryRestrictionSetting) {
    $categoryRestriction = '';
    $categoryRestriction = match ($categoryRestrictionSetting) {
        'current_pid' => ' AND sys_category.pid=###CURRENT_PID### ',
        'siteroot' => ' AND sys_category.pid IN (###SITEROOT###) ',
        'page_tsconfig' => ' AND sys_category.pid IN (###PAGE_TSCONFIG_IDLIST###) ',
        default => '',
    };

    // prepend category restriction at the beginning of foreign_table_where
    if (!empty($categoryRestriction)) {
        $GLOBALS['TCA']['tx_cartbooks_domain_model_book']['columns']['category']['config']['foreign_table_where'] = $categoryRestriction .
            $GLOBALS['TCA']['tx_cartbooks_domain_model_book']['columns']['category']['config']['foreign_table_where'];
        $GLOBALS['TCA']['tx_cartbooks_domain_model_book']['columns']['categories']['config']['foreign_table_where'] = $categoryRestriction .
            $GLOBALS['TCA']['tx_cartbooks_domain_model_book']['columns']['categories']['config']['foreign_table_where'];
    }
}
