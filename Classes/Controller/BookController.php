<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Controller;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Utility\CartUtility;
use Extcode\CartBooks\Domain\Model\Book;
use Extcode\CartBooks\Domain\Model\Dto\BookDemand;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use Extcode\CartBooks\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BookController extends ActionController
{
    /**
     * @var CartUtility
     */
    protected $cartUtility;

    /**
     * @var BookRepository
     */
    protected $bookRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var array
     */
    protected $cartSettings = [];

    public function injectCartUtility(CartUtility $cartUtility): void
    {
        $this->cartUtility = $cartUtility;
    }

    public function injectBookRepository(BookRepository $bookRepository): void
    {
        $this->bookRepository = $bookRepository;
    }

    public function injectCategoryRepository(CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    protected function initializeAction(): void
    {
        $this->cartSettings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'Cart'
        );

        if (!empty($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])) {
            static $cacheTagsSet = false;

            if (!$cacheTagsSet) {
                $GLOBALS['TSFE']->addCacheTags(['tx_cartbooks']);
                $cacheTagsSet = true;
            }
        }
    }

    public function listAction(): void
    {
        if (!$this->settings) {
            $this->settings = [];
        }
        $demand = $this->createDemandObjectFromSettings('list', $this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);

        $books = $this->bookRepository->findDemanded($demand);

        $this->view->assign('books', $books);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($books);
    }

    public function teaserAction(): void
    {
        $limit = (int)$this->settings['limit'] ?: (int)$this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view']['list']['limit'];

        $books = $this->bookRepository->findByUids($limit, $this->settings['bookUids']);

        $this->view->assign('books', $books);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($books);
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("book")
     */
    public function showAction(Book $book = null): void
    {
        if ($book === null) {
            $this->forward('list');
        }

        $this->view->assign('book', $book);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags([$book]);
    }

    protected function createDemandObjectFromSettings(string $type, array $settings): BookDemand
    {
        $demand = GeneralUtility::makeInstance(
            BookDemand::class
        );

        if ($settings['orderBy']) {
            $demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
        }

        $limit = (int)$this->settings['limit'] ?: (int)$this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view'][$type]['limit'];

        $demand->setLimit($limit);

        $order = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view'][$type]['order'];

        if ($order) {
            $demand->setOrder($order);
        }

        $orderBy = $this->settings['orderBy'] ?: $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view'][$type]['orderBy'];

        $orderDirection = $this->settings['orderDirection'] ?: $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view'][$type]['orderDirection'];

        if ($orderBy && $orderDirection) {
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
        $currencyTranslationData = [];

        $cartFrameworkConfig = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'Cart'
        );

        $cart = $this->cartUtility->getCartFromSession($cartFrameworkConfig);

        if ($cart) {
            $currencyTranslationData['currencyCode'] = $cart->getCurrencyCode();
            $currencyTranslationData['currencySign'] = $cart->getCurrencySign();
            $currencyTranslationData['currencyTranslation'] = $cart->getCurrencyTranslation();
        }

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
}
