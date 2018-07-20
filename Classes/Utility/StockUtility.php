<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Utility;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Stock Utility
 *
 * @author Daniel Lorenz <ext.cart@extco.de>
 */
class StockUtility
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * MailHandler constructor
     */
    public function __construct()
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );

        $this->logManager = $this->objectManager->get(
            \TYPO3\CMS\Core\Log\LogManager::class
        );

        $this->persistenceManager = $this->objectManager->get(
            \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class
        );

        $this->configurationManager = $this->objectManager->get(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManager::class
        );

        $this->config = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'CartBooks'
        );
    }

    public function handleStock($params)
    {
        $cartProduct = $params['cartProduct'];

        if ($cartProduct->getProductType() == 'CartBooks') {
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

        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);

        $cacheManager->flushCachesInGroupByTag('pages', $cacheTag);
    }
}
