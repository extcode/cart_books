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
        $this->logManager = GeneralUtility::makeInstance(
            LogManager::class
        );

        $this->persistenceManager = GeneralUtility::makeInstance(
            PersistenceManager::class
        );

        $this->configurationManager = GeneralUtility::makeInstance(
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
            $productRepository = GeneralUtility::makeInstance(
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

        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);

        $cacheManager->flushCachesInGroupByTag('pages', $cacheTag);
    }
}
