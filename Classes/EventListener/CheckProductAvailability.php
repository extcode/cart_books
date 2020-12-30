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
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CheckProductAvailability
{
    /**
     * @bar BookRepository
     */
    protected $bookRepository;

    /**
     * MailHandler constructor
     */
    public function __construct(
        BookRepository $bookRepository
    ) {
        $this->bookRepository = $bookRepository;
    }

    public function __invoke(CheckProductAvailabilityEvent $event): void
    {
        $cart = $event->getCart();
        $cartProduct = $event->getProduct();
        $quantity = $event->getQuantity();
        $mode = $event->getMode();

        if ($cartProduct->getProductType() !== 'CartBooks') {
            return;
        }

        if (($mode === 'add') && $cart->getProduct($cartProduct->getId())) {
            $quantity += $cart->getProduct($cartProduct->getId())->getQuantity();
        }

        $querySettings = $this->bookRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->bookRepository->setDefaultQuerySettings($querySettings);

        $book = $this->bookRepository->findByIdentifier($cartProduct->getProductId());

        if ($book->isHandleStock() && ($quantity > $book->getStock())) {
            $event->setAvailable(false);
            $event->addMessage(
                GeneralUtility::makeInstance(
                    FlashMessage::class,
                    LocalizationUtility::translate(
                        'tx_cart.error.stock_handling.update',
                        'cart'
                    ),
                    '',
                    AbstractMessage::ERROR
                )
            );
        }
    }
}
