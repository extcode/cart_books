<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Utility;

/*
 * This file is part of the package extcode/cart_books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class StockUtility
{
    /**
     * @var ConfigurationManager
     */
    protected $configurationManager = null;

    /**
     * @var LogManager
     */
    protected $logManager = null;

    /**
     * @var ObjectManager
     */
    protected $objectManager = null;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager = null;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * MailHandler constructor
     */
    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(
            ObjectManager::class
        );

        $this->logManager = $this->objectManager->get(
            LogManager::class
        );

        $this->persistenceManager = $this->objectManager->get(
            PersistenceManager::class
        );

        $this->configurationManager = $this->objectManager->get(
            ConfigurationManager::class
        );

        $this->config = $this->configurationManager->getConfiguration(
            ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK,
            'CartBooks'
        );
    }

    public function handleStock($params)
    {
        $cartProduct = $params['cartProduct'];

        if ($cartProduct->getProductType() === 'CartBooks') {
            $productRepository = $this->objectManager->get(
                \Extcode\CartBooks\Domain\Repository\BookRepository::class
            );

            $cartProductId = $cartProduct->getProductId();
            $product = $productRepository->findByUid($cartProductId);

            if ($product && $product->isHandleStock()) {
                $product->setStock($product->getStock() - $cartProduct->getQuantity());
                $productRepository->update($product);
                $this->persistenceManager->persistAll();

                $this->flushCache($product->getUid());
            }
        }
    }

    /**
     * @param int $cartProductId
     */
    protected function flushCache(int $cartProductId)
    {
        $cacheTag = 'tx_cartbooks_book_' . $cartProductId;

        $cacheManager = $this->objectManager->get(CacheManager::class);

        $cacheManager->flushCachesInGroupByTag('pages', $cacheTag);
    }
}
