<?php

defined('TYPO3') or die();

$_LLL_db = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_db.xlf:';

$GLOBALS['TCA']['tx_cart_domain_model_order_product']['columns']['product_type']['config']['items'][] = [
    $_LLL_db . 'tx_cart_domain_model_order_product.product_type.cart_books', 'CartBooks',
];
