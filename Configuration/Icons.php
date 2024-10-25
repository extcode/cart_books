<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'ext-cartbooks-wizard-icon' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_books/Resources/Public/Icons/cartbooks_plugin_wizard.svg',
    ],
];
