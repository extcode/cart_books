<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Controller;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\Cart;
use Extcode\Cart\Service\SessionHandler;
use Extcode\Cart\Utility\CartUtility;
use Extcode\CartBooks\Domain\Model\Book;
use Extcode\CartBooks\Domain\Model\Dto\BookDemand;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use Extcode\CartBooks\Domain\Repository\CategoryRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

class BookController extends ActionController
{
    protected Cart $cart;

    protected array $cartConfiguration = [];

    public function __construct(
        protected readonly SessionHandler $sessionHandler,
        protected readonly CartUtility $cartUtility,
        protected readonly BookRepository $bookRepository,
        protected readonly CategoryRepository $categoryRepository
    ) {}

    protected function initializeAction(): void
    {
        $this->cartConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'Cart'
        );

        if (!empty($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])) {
            static $cacheTagsSet = false;

            if (!$cacheTagsSet) {
                $GLOBALS['TSFE']->addCacheTags(['tx_cartbooks']);
                $cacheTagsSet = true;
            }
        }

        $this->settings['addToCartByAjax'] = isset($this->settings['addToCartByAjax']) ? (int)$this->settings['addToCartByAjax'] : 0;
    }

    public function listAction(int $currentPage = 1): ResponseInterface
    {
        if (!$this->settings) {
            $this->settings = [];
        }
        $demand = $this->createDemandObjectFromSettings('list');
        $demand->setActionAndClass(__METHOD__, self::class);

        $itemsPerPage = $this->settings['itemsPerPage'] ?? 20;

        $books = $this->bookRepository->findDemanded($demand);
        $arrayPaginator = new QueryResultPaginator(
            $books,
            $currentPage,
            $itemsPerPage
        );
        $pagination = new SimplePagination($arrayPaginator);
        $this->view->assignMultiple(
            [
                'books' => $books,
                'paginator' => $arrayPaginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
            ]
        );

        $this->view->assign('cartSettings', $this->cartConfiguration['settings']);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($books);
        return $this->htmlResponse();
    }

    public function teaserAction(): ResponseInterface
    {
        $limit = (int)$this->settings['limit'] ?: (int)$this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view']['list']['limit'];

        $books = $this->bookRepository->findByUids($limit, $this->settings['bookUids']);

        $this->view->assign('books', $books);
        $this->view->assign('cartSettings', $this->cartConfiguration['settings']);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($books);
        return $this->htmlResponse();
    }

    #[IgnoreValidation(['value' => 'book'])]
    public function showAction(Book $book = null): ResponseInterface
    {
        if ($book === null) {
            return new ForwardResponse('list');
        }

        $this->view->assign('book', $book);
        $this->view->assign('cartSettings', $this->cartConfiguration['settings']);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags([$book]);
        return $this->htmlResponse();
    }

    protected function createDemandObjectFromSettings(string $type): BookDemand
    {
        $demand = GeneralUtility::makeInstance(
            BookDemand::class
        );

        if (
            isset($this->settings['view'][$type]) &&
            is_array($this->settings['view'][$type])
        ) {
            // Use default TypoScript settings for plugin configuration
            $limit = (int)$this->settings['view'][$type]['limit'];
            $orderBy = $this->settings['view'][$type]['orderBy'];
            $orderDirection = $this->settings['view'][$type]['orderDirection'];
        }

        if (isset($this->settings['limit']) && (int)$this->settings['limit'] > 0) {
            $limit = (int)$this->settings['limit'];
        }
        if (isset($limit) && $limit > 0) {
            $demand->setLimit($limit);
        }

        if (isset($this->settings['orderBy']) && !empty($this->settings['orderBy'])) {
            $orderBy = $this->settings['orderBy'];
        }
        if (isset($this->settings['orderDirection']) && !empty($this->settings['orderDirection'])) {
            $orderDirection = $this->settings['orderDirection'];
        }
        if (isset($orderBy) && isset($orderDirection)) {
            $demand->setOrder($orderBy . ' ' . $orderDirection);
        }

        $this->addCategoriesToDemandObjectFromSettings($demand);

        return $demand;
    }

    protected function addCategoriesToDemandObjectFromSettings(BookDemand $demand): void
    {
        if ($this->settings['categoriesList']) {
            $selectedCategories = GeneralUtility::intExplode(
                ',',
                $this->settings['categoriesList'],
                true
            );

            $categories = [];

            if ($this->settings['listSubcategories']) {
                foreach ($selectedCategories as $selectedCategory) {
                    $category = $this->categoryRepository->findByUid($selectedCategory);
                    $categories = array_merge(
                        $categories,
                        $this->categoryRepository->findSubcategoriesRecursiveAsArray($category)
                    );
                }
            } else {
                $categories = $selectedCategories;
            }

            $demand->setCategories($categories);
        }
    }

    protected function assignCurrencyTranslationData(): void
    {
        $this->restoreSession();

        $currencyTranslationData = [
            'currencyCode' => $this->cart->getCurrencyCode(),
            'currencySign' => $this->cart->getCurrencySign(),
            'currencyTranslation' => $this->cart->getCurrencyTranslation(),
        ];

        $this->view->assign('currencyTranslationData', $currencyTranslationData);
    }

    protected function addCacheTags(iterable $books): void
    {
        $cacheTags = [];

        if (!empty($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])) {
            foreach ($books as $book) {
                $cacheTags[] = 'tx_cartbooks_book_' . $book->getUid();
            }
            if (count($cacheTags) > 0) {
                $GLOBALS['TSFE']->addCacheTags($cacheTags);
            }
        }
    }

    protected function restoreSession(): void
    {
        $cart = $this->sessionHandler->restoreCart($this->cartConfiguration['settings']['cart']['pid']);

        if ($cart instanceof Cart) {
            $this->cart = $cart;
            return;
        }

        $this->cart = $this->cartUtility->getNewCart($this->cartConfiguration);
        $this->sessionHandler->writeCart($this->cartConfiguration['settings']['cart']['pid'], $this->cart);
    }
}
