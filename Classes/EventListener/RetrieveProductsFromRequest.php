<?php

declare(strict_types=1);

namespace Extcode\CartBooks\EventListener;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\Product;
use Extcode\Cart\Event\RetrieveProductsFromRequestEvent;
use Extcode\CartBooks\Domain\Model\Book;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

final class RetrieveProductsFromRequest
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    ) {}

    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();
        $cart = $event->getCart();
        $requestArguments = $request->getArguments();
        $taxClasses = $cart->getTaxClasses();

        if ($requestArguments['productType'] !== 'CartBooks') {
            return;
        }

        $errors = $this->checkRequestArguments($requestArguments);

        if (!empty($errors)) {
            $event->setErrors($errors);
            return;
        }

        $book = $this->bookRepository->findByUid((int)$requestArguments['book']);

        $quantity = (int)$requestArguments['quantity'];

        $event->addProduct(
            $this->getCartProductFromBook($book, $quantity, $taxClasses)
        );
    }

    protected function getCartProductFromBook(
        Book $book,
        int $quantity,
        array $taxClasses
    ): Product {
        return new Product(
            'CartBooks',
            $book->getUid(),
            $book->getSku(),
            $book->getTitle(),
            $book->getBestSpecialPrice(),
            $taxClasses[$book->getTaxClassId()],
            $quantity,
            false,
            null
        );
    }

    protected function checkRequestArguments(array $requestArguments): array
    {
        if (!(int)$requestArguments['book']) {
            return [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cartbooks.error.book_not_found',
                    'CartBooks'
                ),
                ContextualFeedbackSeverity::ERROR,
            ];
        }

        if ((int)$requestArguments['quantity'] < 0) {
            return [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cart.error.invalid_quantity',
                    'CartBooks'
                ),
                'severity' => ContextualFeedbackSeverity::WARNING,
            ];
        }

        return [];
    }
}
