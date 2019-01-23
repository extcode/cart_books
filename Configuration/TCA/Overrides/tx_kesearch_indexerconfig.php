<?php
declare(strict_types=1);

defined('TYPO3_MODE') or die();

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('ke_search')) {
    $GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['startingpoints_recursive']['displayCond'] .=
        ',cartbookindexer';
}
