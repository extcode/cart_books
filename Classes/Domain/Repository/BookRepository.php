<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Repository;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartBooks\Domain\Model\Dto\BookDemand;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class BookRepository extends Repository
{
    public function findDemanded(BookDemand $demand): QueryResultInterface
    {
        $query = $this->createQuery();

        $constraints = [];

        if ($demand->getSku()) {
            $constraints[] = $query->equals('sku', $demand->getSku());
        }
        if ($demand->getTitle()) {
            $constraints[] = $query->like('title', '%' . $demand->getTitle() . '%');
        }

        if (!empty($demand->getCategories())) {
            $categoryConstraints = [];
            foreach ($demand->getCategories() as $category) {
                $categoryConstraints[] = $query->contains('category', $category);
                $categoryConstraints[] = $query->contains('categories', $category);
            }
            $constraints = $query->logicalOr($categoryConstraints);
        }

        if (!empty($constraints)) {
            $query->matching(
                $query->logicalAnd($constraints)
            );
        }

        if ($orderings = $this->createOrderingsFromDemand($demand)) {
            $query->setOrderings($orderings);
        }

        if ($limit = $demand->getLimit()) {
            $query->setLimit($limit);
        }

        return $query->execute();
    }

    public function findByUids(int $limit, string $uids): array
    {
        $uids = explode(',', $uids);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $query->matching(
            $query->in('uid', $uids)
        );
        if ($limit) {
            $query->setLimit($limit);
        }

        return $this->orderByField($query->execute(), $uids);
    }

    protected function createOrderingsFromDemand(BookDemand $demand) : array
    {
        $orderings = [];

        $orderList = GeneralUtility::trimExplode(',', $demand->getOrder(), true);

        if (!empty($orderList)) {
            foreach ($orderList as $orderItem) {
                list($orderField, $ascDesc) =
                    GeneralUtility::trimExplode(' ', $orderItem, true);
                if ($ascDesc) {
                    $orderings[$orderField] = ((strtolower($ascDesc) === 'desc') ?
                        QueryInterface::ORDER_DESCENDING :
                        QueryInterface::ORDER_ASCENDING);
                } else {
                    $orderings[$orderField] = QueryInterface::ORDER_ASCENDING;
                }
            }
        }

        return $orderings;
    }

    protected function orderByField(QueryResultInterface $books, $uids): array
    {
        $indexedBooks = [];
        $orderedBooks = [];

        // Create an associative array
        foreach ($books as $object) {
            $indexedBooks[$object->getUid()] = $object;
        }
        // add to ordered array in right order
        foreach ($uids as $uid) {
            if (isset($indexedBooks[$uid])) {
                $orderedBooks[] = $indexedBooks[$uid];
            }
        }

        return $orderedBooks;
    }
}
