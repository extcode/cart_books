<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Domain\Repository\PageRepository;

return [
    'pages' => [
        0 => [
            'uid' => '1',
            'pid' => '0',
            'title' => 'Home',
            'doktype' => PageRepository::DOKTYPE_DEFAULT,
            'slug' => '/',
            'sorting' => '128',
            'deleted' => '0',
            'is_siteroot' => '1',
        ],
        1 => [
            'uid' => '2',
            'pid' => '0',
            'title' => 'Startseite',
            'doktype' => PageRepository::DOKTYPE_DEFAULT,
            'slug' => '/',
            'sorting' => '128',
            'deleted' => '0',
            'is_siteroot' => '1',
            'sys_language_uid' => 2,
            'l10n_parent' => 1,
            'l10n_source' => 1,
        ],
        2 => [
            'uid' => '3',
            'pid' => '1',
            'title' => 'Books',
            'doktype' => PageRepository::DOKTYPE_DEFAULT,
            'slug' => '/books',
            'sorting' => '128',
            'deleted' => '0',
        ],
        3 => [
            'uid' => '4',
            'pid' => '1',
            'title' => 'Bücher',
            'doktype' => PageRepository::DOKTYPE_DEFAULT,
            'slug' => '/buecher',
            'sorting' => '128',
            'deleted' => '0',
            'sys_language_uid' => 2,
            'l10n_parent' => 3,
            'l10n_source' => 3,
        ],
        4 => [
            'uid' => '5',
            'pid' => '1',
            'title' => 'Shop',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
            'slug' => '/shop',
            'sorting' => '128',
            'deleted' => '0',
        ],
        5 => [
            'uid' => '6',
            'pid' => '1',
            'title' => 'Shop',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
            'slug' => '/shop',
            'sorting' => '128',
            'deleted' => '0',
            'sys_language_uid' => 2,
            'l10n_parent' => 5,
            'l10n_source' => 5,
        ],
        6 => [
            'uid' => '7',
            'pid' => '5',
            'title' => 'Books Folder 1',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
            'slug' => '/books-folder-1',
            'sorting' => '128',
            'deleted' => '0',
        ],
        7 => [
            'uid' => '8',
            'pid' => '5',
            'title' => 'Bücherordner 1',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
            'slug' => '/buecherordner-1',
            'sorting' => '128',
            'deleted' => '0',
            'sys_language_uid' => 2,
            'l10n_parent' => 7,
            'l10n_source' => 7,
        ],
        8 => [
            'uid' => '9',
            'pid' => '5',
            'title' => 'Books Folder 2',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
            'slug' => '/books-folder-2',
            'sorting' => '128',
            'deleted' => '0',
        ],
        9 => [
            'uid' => '10',
            'pid' => '5',
            'title' => 'Bücherordner 2',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
            'slug' => '/buecherordner-2',
            'sorting' => '128',
            'deleted' => '0',
            'sys_language_uid' => 2,
            'l10n_parent' => 9,
            'l10n_source' => 9,
        ],
        10 => [
            'uid' => '11',
            'pid' => '1',
            'title' => 'Cart',
            'doktype' => PageRepository::DOKTYPE_DEFAULT,
            'slug' => '/cart',
            'sorting' => '128',
            'deleted' => '0',
        ],
        11 => [
            'uid' => '12',
            'pid' => '1',
            'title' => 'Warenkorb',
            'doktype' => PageRepository::DOKTYPE_DEFAULT,
            'slug' => '/warenkorb',
            'sorting' => '128',
            'deleted' => '0',
            'sys_language_uid' => 2,
            'l10n_parent' => 11,
            'l10n_source' => 11,
        ],
        12 => [
            'uid' => '13',
            'pid' => '5',
            'title' => 'Orders',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
            'slug' => '/orders',
            'sorting' => '128',
            'deleted' => '0',
        ],
        13 => [
            'uid' => '14',
            'pid' => '5',
            'title' => 'Bestellungen',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
            'slug' => '/bestellungen',
            'sorting' => '128',
            'deleted' => '0',
            'sys_language_uid' => 2,
            'l10n_parent' => 13,
            'l10n_source' => 13,
        ],
    ],
    'sys_template' => [
        0 => [
            'uid' => '1',
            'pid' => '1',
            'title' => 'Test Template',
            'include_static_file' => 'EXT:fluid_styled_content/Configuration/TypoScript/,EXT:cart_books_test/Configuration/TypoScript,EXT:cart/Configuration/TypoScript,EXT:books/Configuration/TypoScript,EXT:cart_books/Configuration/TypoScript',
        ],
    ],
];
