<?php

$EM_CONF['cart_books'] = [
    'title' => 'Cart - Books',
    'description' => 'Shopping Cart(s) for TYPO3 - Book Extension',
    'category' => 'plugin',
    'version' => '7.0.0',
    'state' => 'stable',
    'author' => 'Daniel Gohlke',
    'author_email' => 'ext@extco.de',
    'author_company' => 'extco.de UG (haftungsbeschränkt)',
    'constraints' => [
        'depends' => [
            'typo3' => '14.1.0-14.4.99',
            'cart' => '12.0.0',
            'books' => '2.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
