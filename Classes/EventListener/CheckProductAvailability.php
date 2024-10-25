<?php

declare(strict_types=1);

namespace Extcode\CartBooks\EventListener;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\CheckProductAvailabilityEvent;
use Extcode\CartBooks\Domain\Model\Book;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

final class CheckProductAvailability
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    ) {}

    public function __invoke(CheckProductAvailabilityEvent $event): void
    {
        $cart = $event->getCart();
        $cartProduct = $event->getProduct();
        $quantity = $event->getQuantity();
        $mode = $event->getMode();

        if ($cartProduct->getProductType() !== 'CartBooks') {
            return;
        }

        if (($mode === 'add') && $cart->getProductById($cartProduct->getId())) {
            $quantity += $cart->getProductById($cartProduct->getId())->getQuantity();
        }

        $querySettings = $this->bookRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->bookRepository->setDefaultQuerySettings($querySettings);

        $book = $this->bookRepository->findByIdentifier($cartProduct->getProductId());

        if (
            !$book instanceof Book ||
            (
                $book->isHandleStock() &&
                ($quantity > $book->getStock())
            )
        ) {
            $event->setAvailable(false);
            $event->addMessage(
                GeneralUtility::makeInstance(
                    FlashMessage::class,
                    LocalizationUtility::translate(
                        'tx_cart.error.stock_handling.update',
                        'cart'
                    ),
                    '',
                    ContextualFeedbackSeverity::ERROR
                )
            );
        }
    }
}
