<?php

defined('TYPO3') or die();

$_LLL_be = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:';

// register "cartbooks:" namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['cartbooks'][]
    = 'Extcode\\CartBooks\\ViewHelpers';
