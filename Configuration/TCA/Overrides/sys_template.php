<?php
declare(strict_types=1);

defined('TYPO3_MODE') or die();

call_user_func(function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'cart_books',
        'Configuration/TypoScript',
        'Shopping Cart - Cart Books'
    );
});
