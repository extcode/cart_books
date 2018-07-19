<?php
declare(strict_types=1);
defined('TYPO3_MODE') or die();

call_user_func(function () {
    $_LLL = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf';

    $GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
        $_LLL . ':pages.doktype.188',
        188,
        'icon-apps-pagetree-cartbooks-page',
    ];

    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][188] = 'icon-apps-pagetree-cartbooks-page';
});
