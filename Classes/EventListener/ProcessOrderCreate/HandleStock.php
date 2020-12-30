<?php
declare(strict_types=1);
namespace Extcode\CartBooks\EventListener\ProcessOrderCreate;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\ProcessOrderCreateEvent;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class HandleStock
{
    /**
     * @var PersistenceManager
     */
    protected $persistenceManager = null;

    /**
     * @bar BookRepository
     */
    protected $bookRepository;

    public function __construct(
        PersistenceManager $persistenceManager,
        BookRepository $bookRepository
    ) {
        $this->persistenceManager = $persistenceManager;
        $this->bookRepository = $bookRepository;
    }

    public function __invoke(ProcessOrderCreateEvent $event): void
    {
        $cartProducts = $event->getCart()->getProducts();

        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() === 'CartBooks') {
                $cartProductId = $cartProduct->getProductId();
                $product = $this->bookRepository->findByUid($cartProductId);

                if ($product && $product->isHandleStock()) {
                    $product->setStock($product->getStock() - $cartProduct->getQuantity());
                    $this->bookRepository->update($product);
                    $this->persistenceManager->persistAll();
                }
            }
        }
    }
}
