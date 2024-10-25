<?php

declare(strict_types=1);

namespace Extcode\CartBooks\EventListener\Order\Stock;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\Order\EventInterface;
use Extcode\CartBooks\Domain\Model\Book;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

final class HandleStock
{
    public function __construct(
        private readonly PersistenceManager $persistenceManager,
        private readonly BookRepository $bookRepository
    ) {}

    public function __invoke(EventInterface $event): void
    {
        $cartProducts = $event->getCart()->getProducts();

        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() === 'CartBooks') {
                $cartProductId = $cartProduct->getProductId();
                $product = $this->bookRepository->findByUid($cartProductId);

                if ($product instanceof Book && $product->isHandleStock()) {
                    $product->setStock($product->getStock() - $cartProduct->getQuantity());
                    $this->bookRepository->update($product);
                    $this->persistenceManager->persistAll();
                }
            }
        }
    }
}
