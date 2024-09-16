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
use TYPO3\CMS\Core\Cache\CacheManager;

class FlushCache
{
    public function __construct(
        private readonly CacheManager $cacheManager
    ) {}

    public function __invoke(EventInterface $event): void
    {
        $cartProducts = $event->getCart()->getProducts();

        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() === 'CartBooks') {
                $cartProductId = $cartProduct->getProductId();

                $cacheTag = 'tx_cartbooks_book_' . $cartProductId;
                $this->cacheManager->flushCachesInGroupByTag('pages', $cacheTag);
            }
        }
    }
}
