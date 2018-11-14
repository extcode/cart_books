<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Controller;

use Extcode\CartBooks\Domain\Model\Dto\BookDemand;
use Extcode\CartBooks\Domain\Repository\BookRepository;

/**
 * Book Controller
 *
 * @author Daniel Lorenz <ext.cart@extco.de>
 */
class BookController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * Cart Utility
     *
     * @var \Extcode\Cart\Utility\CartUtility
     */
    protected $cartUtility;

    /**
     * @var BookRepository
     */
    protected $bookRepository;

    /**
     * categoryRepository
     *
     * @var \Extcode\CartBooks\Domain\Repository\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var array
     */
    protected $cartSettings = [];

    /**
     * @param \Extcode\Cart\Utility\CartUtility $cartUtility
     */
    public function injectCartUtility(
        \Extcode\Cart\Utility\CartUtility $cartUtility
    ) {
        $this->cartUtility = $cartUtility;
    }

    /**
     * @param BookRepository $bookRepository
     */
    public function injectBookRepository(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param \Extcode\CartBooks\Domain\Repository\CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(
        \Extcode\CartBooks\Domain\Repository\CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Action initialize
     */
    protected function initializeAction()
    {
        $this->cartSettings = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
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

    public function listAction()
    {
        if (!$this->settings) {
            $this->settings = [];
        }
        $demand = $this->createDemandObjectFromSettings('list', $this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);

        $books = $this->bookRepository->findDemanded($demand);

        $this->view->assign('books', $books);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->addCacheTags($books);
    }

    /**
     * action teaser
     */
    public function teaserAction()
    {
        $limit = (int)$this->settings['limit'] ?: (int)$this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view']['list']['limit'];

        $books = $this->bookRepository->findByUids($limit, $this->settings['bookUids']);

        $this->view->assign('books', $books);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->addCacheTags($books);
    }

    /**
     * @param \Extcode\CartBooks\Domain\Model\Book $book
     *
     * @ignorevalidation $book
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function showAction(\Extcode\CartBooks\Domain\Model\Book $book = null)
    {
        if (empty($book)) {
            $this->forward('list');
        }

        $this->view->assign('book', $book);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags([$book]);
    }

    /**
     * Create the demand object which define which records will get shown
     *
     * @param string $type
     * @param array $settings
     *
     * @return BookDemand
     */
    protected function createDemandObjectFromSettings(string $type, array $settings) : BookDemand
    {
        /** @var BookDemand $demand */
        $demand = $this->objectManager->get(
            BookDemand::class
        );

        if ($settings['orderBy']) {
            $demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
        }

        $limit = (int)$this->settings['limit'] ?: (int)$this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view'][$type]['limit'];

        $demand->setLimit($limit);

        $order = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view'][$type]['order'];

        if ($order) {
            $demand->setOrder($order);
        }

        $orderBy = $this->settings['orderBy'] ?: $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view'][$type]['orderBy'];

        $orderDirection = $this->settings['orderDirection'] ?: $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'CartBooks'
        )['view'][$type]['orderDirection'];

        if ($orderBy && $orderDirection) {
            $demand->setOrder($orderBy . ' ' . $orderDirection);
        }

        $this->addCategoriesToDemandObjectFromSettings($demand);

        return $demand;
    }

    /**
     * @param BookDemand $demand
     */
    protected function addCategoriesToDemandObjectFromSettings(BookDemand &$demand)
    {
        if ($this->settings['categoriesList']) {
            $selectedCategories = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(
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

    /**
     * assigns currency translation array to view
     */
    protected function assignCurrencyTranslationData()
    {
        if (TYPO3_MODE === 'FE') {
            $currencyTranslationData = [];

            $cartFrameworkConfig = $this->configurationManager->getConfiguration(
                \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
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
    }

    /**
     * @param $books
     */
    protected function addCacheTags($books)
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
