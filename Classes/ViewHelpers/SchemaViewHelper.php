<?php
declare(strict_types=1);

namespace Extcode\CartBooks\ViewHelpers;

/*
 * This file is part of the package extcode/cart_books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class SchemaViewHelper extends AbstractViewHelper
{
    /**
     * Output is escaped already. We must not escape children, to avoid double encoding.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('book', \Extcode\CartBooks\Domain\Model\Book::class, 'book', true);
    }

    public function render()
    {
        /** @var \Extcode\CartBooks\Domain\Model\Book $book */
        $book = $this->arguments['book'];

        $schemaBook = [
            '@context' => 'http://schema.org',
            '@type' => 'Book',
            'additionalType' => 'Product',
            'name' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'offers' => [
                '@type' => 'Offer',
                'price' => $book->getPrice(),
                'priceCurrency' => 'EUR',
            ],
        ];

        return json_encode($schemaBook);
    }
}
