<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'apps-pagetree-folder-cartbooks-books' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_books/Resources/Public/Icons/apps_pagetree_folder_cartbooks_books.svg',
    ],
    'apps-pagetree-page-cartbooks-book' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_books/Resources/Public/Icons/apps_pagetree_page_cartbooks_books.svg',
    ],
    'ext-cartbooks-wizard-icon' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_books/Resources/Public/Icons/cartbooks_plugin_wizard.svg',
    ],
];
