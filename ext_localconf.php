<?php

use Extcode\CartBooks\Updates\SlugUpdater;

defined('TYPO3') or die();

$_LLL_be = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:';

// register "cartbooks:" namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['cartbooks'][]
    = 'Extcode\\CartBooks\\ViewHelpers';

// update wizard for slugs
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['cartBooksSlugUpdater'] =
    SlugUpdater::class;
