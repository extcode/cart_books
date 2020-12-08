<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Finisher\Cart;

/*
 * This file is part of the package extcode/cart_books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Finisher\Cart\AddToCartFinisherInterface;
use Extcode\Cart\Domain\Model\Cart\Cart;
use Extcode\Cart\Domain\Model\Cart\Product;
use Extcode\Cart\Domain\Model\Dto\AvailabilityResponse;
use Extcode\CartBooks\Domain\Model\Book;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class AddToCartFinisher implements AddToCartFinisherInterface
{
    /**
     * @var BookRepository
     */
    protected $bookRepository;

    /**
     * @param BookRepository $bookRepository
     */
    public function injectBookRepository(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param Request $request
     * @param Product $cartProduct
     * @param Cart $cart
     * @param string $mode
     *
     * @return AvailabilityResponse
     */
    public function checkAvailability(
        Request $request,
        Product $cartProduct,
        Cart $cart,
        string $mode = 'update'
    ): AvailabilityResponse {
        /** @var AvailabilityResponse $availabilityResponse */
        $availabilityResponse = GeneralUtility::makeInstance(
            AvailabilityResponse::class
        );

        if ($request->hasArgument('quantities')) {
            $quantities = $request->getArgument('quantities');
            $quantity = (int)$quantities[$cartProduct->getId()];
        }

        if ($cartProduct->getProductType() !== 'CartBooks') {
            return $availabilityResponse;
        }

        $querySettings = $this->bookRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->bookRepository->setDefaultQuerySettings($querySettings);

        $book = $this->bookRepository->findByIdentifier($cartProduct->getProductId());

        if ($book->isHandleStock() && ($quantity > $book->getStock())) {
            $availabilityResponse->setAvailable(false);
            $flashMessage = GeneralUtility::makeInstance(
                FlashMessage::class,
                LocalizationUtility::translate(
                    'tx_cart.error.stock_handling.update',
                    'cart'
                ),
                '',
                AbstractMessage::ERROR
            );

            $availabilityResponse->addMessage($flashMessage);
        }

        return $availabilityResponse;
    }

    /**
     * @param Request $request
     * @param Cart $cart
     *
     * @return array
     */
    public function getProductFromRequest(Request $request, Cart $cart): array
    {
        $requestArguments = $request->getArguments();
        $taxClasses = $cart->getTaxClasses();

        $errors = [];
        $cartProducts = [];

        if (!(int)$requestArguments['book']) {
            $errors[] = [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cartbooks.error.invalid_book',
                    'cart_books'
                ),
                'severity' => AbstractMessage::ERROR,
            ];

            return [$errors, $cartProducts];
        }

        $quantity = 0;

        if ((int)$requestArguments['quantity']) {
            $quantity = (int)$requestArguments['quantity'];
        }

        if ($quantity < 0) {
            $errors[] = [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cart.error.invalid_quantity',
                    'cart_books'
                ),
                'severity' => AbstractMessage::WARNING,
            ];

            return [$errors, $cartProducts];
        }

        $book = $this->bookRepository->findByUid((int)$requestArguments['book']);

        if (!$book) {
            $errors[] = [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cartbooks.error.book_not_found',
                    'cart_books'
                ),
                'severity' => AbstractMessage::WARNING,
            ];

            return [$errors, $cartProducts];
        }

        $newProduct = $this->getCartProductFromBook($book, $quantity, $taxClasses);

        $this->checkAvailability($request, $newProduct, $cart);

        return [$errors, [$newProduct]];
    }

    /**
     * @param Book $book
     * @param int $quantity
     * @param array $taxClasses
     *
     * @return Product
     */
    protected function getCartProductFromBook(
        Book $book,
        int $quantity,
        array $taxClasses
    ) {
        $product = new Product(
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

        return $product;
    }
}
