<?php
declare(strict_types=1);

defined('TYPO3_MODE') or die();

$_LLL_general = 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf';
$_LLL_cart = 'LLL:EXT:cart/Resources/Private/Language/locallang_db.xlf';
$_LLL_db = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_db.xlf';
$_LLL_tca = 'LLL:EXT:cart_books/Resources/Private/Language/locallang_tca.xlf';

return [
    'ctrl' => [
        'title' => $_LLL_db . ':tx_cartbooks_domain_model_book',
        'label' => 'sku',
        'label_alt' => 'title',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,

        'sortby' => 'sorting',

        'versioningWS' => 2,
        'versioning_followPages' => true,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',

        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'requestUpdate' => '',
        'searchFields' => 'sku,title,teaser,description',
        'iconfile' => 'EXT:cart_books/Resources/Public/Icons/Book.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, sku, title, teaser, description, meta_description, price, tax_class_id, special_prices, handle_stock, stock, category, categories, tags',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource,
                sku, title, author,
                    --palette--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.palette.isbn;isbn,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.descriptions,
                    teaser;;;richtext:rte_transform[mode=ts_links],
                    description;;;richtext:rte_transform[mode=ts_links],
                    meta_description,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.price_and_stock,
                    --palette--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.palette.prices;prices,
                    --palette--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.palette.prices;stock,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.categorization,
                    tags, category, categories,
                --div--;' . $_LLL_tca . ':pages.tabs.access,
                    --palette--;' . $_LLL_tca . ':palettes.visibility;hiddenonly,
                    --palette--;' . $_LLL_tca . ':pages.palettes.access;access,
            ',
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => '',
        ],
        'isbn' => [
            'showitem' => 'isbn10, --linebreak--, isbn13, --linebreak--, issn',
            'canNotCollapse' => 1,
        ],
        'prices' => [
            'showitem' => 'price, tax_class_id, --linebreak--, special_prices',
            'canNotCollapse' => 1,
        ],
        'stock' => [
            'showitem' => 'handle_stock, stock',
            'canNotCollapse' => 1,
        ],
        'hiddenonly' => [
            'showitem' => 'hidden;' . $_LLL_db . ':tx_cartbooks_domain_model_book',
        ],
        'access' => [
            'showitem' => 'starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel, endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => $_LLL_general . ':LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    [$_LLL_general . ':LGL.allLanguages', -1],
                    [$_LLL_general . ':LGL.default_value', 0],
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => $_LLL_general . ':LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_cartbooks_domain_model_book',
                'foreign_table_where' => 'AND tx_cartbooks_domain_model_book.pid=###CURRENT_PID### AND tx_cartbooks_domain_model_book.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => $_LLL_general . ':LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => $_LLL_general . ':LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:hidden.I.0',
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $_LLL_general . ':LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, (int)date('m'), (int)date('d'), (int)date('Y')),
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL' . ':EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, (int)date('m'), (int)date('d'), (int)date('Y')),
                ],
            ],
        ],

        'sku' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.sku',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,trim',
            ],
        ],
        'title' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,trim',
            ],
        ],
        'author' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.author',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],

        'isbn10' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.isbn10',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'isbn13' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.isbn13',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'issn' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.issn',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],

        'teaser' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.teaser',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext[]',
        ],
        'description' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext[]',
        ],
        'meta_description' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.meta_description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],

        'price' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.price',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,double2',
                'default' => '0.00',
            ],
        ],
        'special_prices' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.special_prices',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cartbooks_domain_model_specialprice',
                'foreign_field' => 'book',
                'foreign_table_where' => ' AND tx_cartbooks_domain_model_specialprice.pid=###CURRENT_PID### ',
                'foreign_default_sortby' => 'price ASC',
                'maxitems' => 99,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                ],
            ],
        ],
        'tax_class_id' => [
            'exclude' => 1,
            'label' => $_LLL_cart . ':tx_cart.tax_class_id',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$_LLL_cart . ':tx_cart.tax_class_id.1', 1],
                    [$_LLL_cart . ':tx_cart.tax_class_id.2', 2],
                    [$_LLL_cart . ':tx_cart.tax_class_id.3', 3],
                ],
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],

        'handle_stock' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.handle_stock',
            'config' => [
                'type' => 'check',
            ],
        ],
        'stock' => [
            'exclude' => 1,
            'displayCond' => 'FIELD:handle_stock:=:1',
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.stock',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'int',
                'default' => 0,
            ],
        ],

        'tags' => [
            'exclude' => 1,
            'label' => $_LLL_cart . ':tx_cart_domain_model_tags',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_cart_domain_model_tag',
                'foreign_table' => 'tx_cart_domain_model_tag',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_cartbooks_domain_model_book_tag_mm',
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                        'default' => [
                            'searchWholePhrase' => true,
                        ],
                    ],
                ],
            ],
        ],
    ],
];
