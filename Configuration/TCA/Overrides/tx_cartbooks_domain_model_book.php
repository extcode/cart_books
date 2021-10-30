<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

defined('TYPO3_MODE') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$_LLL_db = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_db.xlf';

ExtensionManagementUtility::makeCategorizable(
    'cart_books',
    'tx_cartbooks_domain_model_book',
    'category',
    [
        'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.category',
        'fieldConfiguration' => [
            'minitems' => 0,
            'maxitems' => 1,
            'multiple' => false,
        ],
    ]
);

$GLOBALS['TCA']['tx_cartbooks_domain_model_book']['category']['config']['maxitems'] = 1;

ExtensionManagementUtility::makeCategorizable(
    'cart_books',
    'tx_cartbooks_domain_model_book',
    'categories',
    [
        'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.categories',
    ]
);

// category restriction based on settings in extension manager
$categoryRestrictionSetting = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('cart_books', 'categoryRestriction');

if ($categoryRestrictionSetting) {
    $categoryRestriction = '';
    switch ($categoryRestrictionSetting) {
        case 'current_pid':
            $categoryRestriction = ' AND sys_category.pid=###CURRENT_PID### ';
            break;
        case 'siteroot':
            $categoryRestriction = ' AND sys_category.pid IN (###SITEROOT###) ';
            break;
        case 'page_tsconfig':
            $categoryRestriction = ' AND sys_category.pid IN (###PAGE_TSCONFIG_IDLIST###) ';
            break;
        default:
            $categoryRestriction = '';
    }

    // prepend category restriction at the beginning of foreign_table_where
    if (!empty($categoryRestriction)) {
        $GLOBALS['TCA']['tx_cartbooks_domain_model_book']['columns']['category']['config']['foreign_table_where'] = $categoryRestriction .
            $GLOBALS['TCA']['tx_cartbooks_domain_model_book']['columns']['category']['config']['foreign_table_where'];
        $GLOBALS['TCA']['tx_cartbooks_domain_model_book']['columns']['categories']['config']['foreign_table_where'] = $categoryRestriction .
            $GLOBALS['TCA']['tx_cartbooks_domain_model_book']['columns']['categories']['config']['foreign_table_where'];
    }
}
