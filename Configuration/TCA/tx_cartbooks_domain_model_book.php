<?php
declare(strict_types=1);

defined('TYPO3_MODE') or die();

$_LLL_general = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf';
$_LLL_ttc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf';
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

        'versioningWS' => true,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'translationSource' => 'l10n_source',

        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'requestUpdate' => '',
        'searchFields' => 'sku,title,teaser,description',
        'iconfile' => 'EXT:cart_books/Resources/Public/Icons/tx_cartbooks_domain_model_book.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, sku, title, subtitle, author, illustrator, editor, publisher, translator, teaser, description, meta_description, price, tax_class_id, special_prices, handle_stock, stock, category, categories, tags, related_books',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                sku,
                    --palette--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.palette.title;title,
                path_segment,
                    --palette--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.palette.isbn;isbn,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.data,
                    --palette--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.palette.author_and_publisher;author_and_publisher,
                    number_of_pages, date_of_publication,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.descriptions,
                    genre,
                    teaser,
                    description,
                    meta_description,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.images_and_files,
                    images, files,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.price_and_stock,
                    --palette--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.palette.prices;prices,
                    --palette--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.palette.prices;stock,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.categorization,
                    tags, category, categories,
                --div--;' . $_LLL_tca . ':tx_cartbooks_domain_model_book.div.related_books,
                    related_books,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
                    --palette--;' . $_LLL_tca . ':palettes.visibility;hiddenonly,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,
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
        'title' => [
            'showitem' => 'title, --linebreak--, subtitle',
            'canNotCollapse' => 1,
        ],
        'author_and_publisher' => [
            'showitem' => 'author, --linebreak--, illustrator, --linebreak--, editor, --linebreak--, publisher, --linebreak--, translator, language',
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
                'eval' => 'int',
                'default' => 0,
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
                'default' => 0,
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
            'label' => $_LLL_general . ':LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
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
            'label' => 'LLL' . ':EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
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
        'subtitle' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],

        'path_segment' => [
            'exclude' => true,
            'label' => $_LLL_db . 'tx_cartbooks_domain_model_book.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['title'],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
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
        'illustrator' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.illustrator',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'editor' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.editor',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'publisher' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.publisher',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'translator' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.translator',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'number_of_pages' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.number_of_pages',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'language' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.language',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'date_of_publication' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.date_of_publication',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
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

        'genre' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.genre',
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
                'enableRichtext' => true,
            ],
        ],
        'description' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
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

        'images' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.images',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'images',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $_LLL_ttc . ':images.addFileReference',
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true,
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'image',
                        'tablenames' => 'tx_cartbooks_domain_model_book',
                        'table_local' => 'sys_file',
                    ],
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                        ],
                    ],
                    'minitems' => 0,
                    'maxitems' => 99,
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],

        'files' => [
            'exclude' => 1,
            'label' => $_LLL_db . ':tx_cartbooks_domain_model_book.files',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'files',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $_LLL_ttc . ':images.addFileReference',
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true,
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'files',
                        'tablenames' => 'tx_cartbooks_domain_model_book',
                        'table_local' => 'sys_file',
                    ],
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                            ],
                        ],
                    ],
                    'minitems' => 0,
                    'maxitems' => 99,
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] . ', pdf'
            ),
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

        'related_books' => [
            'exclude' => 1,
            'label' => $_LLL_db . 'tx_cartbooks_domain_model_book.related_books',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_cartbooks_domain_model_book',
                'foreign_table' => 'tx_cartbooks_domain_model_book',
                'MM_opposite_field' => 'related_books_from',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_cartbooks_domain_model_book_related_mm',
                'suggestOptions' => [
                    'default' => [
                        'searchWholePhrase' => true,
                    ],
                ],
            ],
        ],

        'related_books_from' => [
            'exclude' => 1,
            'label' => $_LLL_db . 'tx_cartbooks_domain_model_book.related_books_from',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'foreign_table' => 'tx_cartbooks_domain_model_book',
                'allowed' => 'tx_cartbooks_domain_model_book',
                'size' => 5,
                'maxitems' => 100,
                'MM' => 'tx_cartbooks_domain_model_book_related_mm',
                'readOnly' => 1,
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
                'suggestOptions' => [
                    'default' => [
                        'searchWholePhrase' => true,
                    ],
                ],
            ],
        ],
    ],
];
