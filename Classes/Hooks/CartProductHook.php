<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * CheckAvailability Hook
 *
 * @author Daniel Lorenz <ext.cart@extco.de>
 */
class CartProductHook implements \Extcode\Cart\Hooks\CartProductHookInterface
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * Slot Repository
     *
     * @var \Extcode\CartBooks\Domain\Repository\BooksRepository
     */
    protected $bookRepository;

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\Web\Request $request
     * @param \Extcode\Cart\Domain\Model\Cart\Product $cartProduct
     * @param \Extcode\Cart\Domain\Model\Cart\Cart $cart
     *
     * @return \Extcode\Cart\Domain\Model\Dto\AvailabilityResponse
     */
    public function checkAvailability(
        \TYPO3\CMS\Extbase\Mvc\Web\Request $request,
        \Extcode\Cart\Domain\Model\Cart\Product $cartProduct,
        \Extcode\Cart\Domain\Model\Cart\Cart $cart,
        string $mode = 'update'
    ): \Extcode\Cart\Domain\Model\Dto\AvailabilityResponse {
        $this->objectManager = GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );

        $availabilityResponse = GeneralUtility::makeInstance(
            \Extcode\Cart\Domain\Model\Dto\AvailabilityResponse::class
        );

        if ($request->hasArgument('quantities')) {
            $quantities = $request->getArgument('quantities');
            $quantity = (int)$quantities[$cartProduct->getId()];
        }

        if ($cartProduct->getProductType() != 'CartBooks') {
            return $availabilityResponse;
        }

        $this->bookRepository = $this->objectManager->get(
            \Extcode\CartBooks\Domain\Repository\BookRepository::class
        );

        $querySettings = $this->bookRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->bookRepository->setDefaultQuerySettings($querySettings);

        $book = $this->bookRepository->findByIdentifier($cartProduct->getProductId());

        if ($book->isHandleStock() && ($quantity > $book->getStock())) {
            $availabilityResponse->setAvailable(false);
            $flashMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                \TYPO3\CMS\Core\Messaging\FlashMessage::class,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_cart.error.stock_handling.update',
                    'cart'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $availabilityResponse->addMessage($flashMessage);
        }

        return $availabilityResponse;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\Web\Request $request
     * @param \Extcode\Cart\Domain\Model\Cart\Cart $cart
     *
     * @return array
     */
    public function getProductFromRequest(
        \TYPO3\CMS\Extbase\Mvc\Web\Request $request,
        \Extcode\Cart\Domain\Model\Cart\Cart $cart
    ) {
        $requestArguments = $request->getArguments();
        $taxClasses = $cart->getTaxClasses();

        $errors = [];
        $cartProducts = [];

        if (!(int)$requestArguments['book']) {
            $errors[] = [
                'messageBody' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_cartbooks.error.invalid_book',
                    'cart_books'
                ),
                'severity' => \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR,
            ];

            return [$errors, $cartProducts];
        }

        $quantity = 0;

        if ((int)$requestArguments['quantity']) {
            $quantity = (int)$requestArguments['quantity'];
        }

        if ($quantity < 0) {
            $errors[] = [
                'messageBody' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_cart.error.invalid_quantity',
                    'cart_books'
                ),
                'severity' => \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
            ];

            return [$errors, $cartProducts];
        }

        $this->objectManager = GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );
        $this->bookRepository = $this->objectManager->get(
            \Extcode\CartBooks\Domain\Repository\BookRepository::class
        );

        $book = $this->bookRepository->findByUid((int)$requestArguments['book']);

        if (!$book) {
            $errors[] = [
                'messageBody' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_cartbooks.error.book_not_found',
                    'cart_books'
                ),
                'severity' => \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
            ];

            return [$errors, $cartProducts];
        }

        /**
         * TODO:
         *
         * if ($this->areEnoughSeatsAvailable($book, $newProduct)) {
         * $this->cart->addProduct($newProduct);
         *
         * $this->cartUtility->writeCartToSession($this->cart, $this->cartFrameworkConfig['settings']);
         *
         * $message = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
         * 'tx_cartbooks.plugin.form.submit.success',
         * 'cart_books'
         * );
         * }
         */
        $topic = null;
        $date = null;

        $newProduct = $this->getProductFromSlot($book, $quantity, $taxClasses);

        $this->checkAvailability($request, $newProduct, $cart);

        return [$errors, [$newProduct]];
    }

    /**
     * @param \Extcode\CartBooks\Domain\Model\Book $book
     * @param int $quantity
     * @param array $taxClasses
     *
     * @return \Extcode\Cart\Domain\Model\Cart\Product
     */
    protected function getProductFromSlot(
        \Extcode\CartBooks\Domain\Model\Book $book,
        int $quantity,
        array $taxClasses
    ) {
        $title = implode(' - ', [$book->getTitle(), $book->getTitle()]);
        $sku = implode(' - ', [$book->getSku(), $book->getSku()]);

        $product = new \Extcode\Cart\Domain\Model\Cart\Product(
            'CartBooks',
            $book->getUid(),
            $sku,
            $title,
            $book->getBestSpecialPrice(),
            $taxClasses[$book->getTaxClassId()],
            $quantity,
            false,
            null
        );

        return $product;
    }
}
