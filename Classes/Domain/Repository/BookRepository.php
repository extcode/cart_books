<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Repository;

/*
 * This file is part of the package extcode/cart_books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartBooks\Domain\Model\Dto\BookDemand;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class BookRepository extends Repository
{
    /**
     * @param BookDemand $demand
     *
     * @return QueryResultInterface|array
     */
    public function findDemanded(BookDemand $demand)
    {
        $query = $this->createQuery();

        $constraints = [];

        if ($demand->getSku()) {
            $constraints[] = $query->equals('sku', $demand->getSku());
        }
        if ($demand->getTitle()) {
            $constraints[] = $query->like('title', '%' . $demand->getTitle() . '%');
        }

        if ((!empty($demand->getCategories()))) {
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

    /**
     * Find all books based on selected uids
     *
     * @param int $limit
     * @param string $uids
     *
     * @return array
     */
    public function findByUids(int $limit, string $uids)
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

    /**
     * @param BookDemand $demand
     *
     * @return array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface>
     */
    protected function createOrderingsFromDemand(BookDemand $demand) : array
    {
        $orderings = [];

        $orderList = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $demand->getOrder(), true);

        if (!empty($orderList)) {
            foreach ($orderList as $orderItem) {
                list($orderField, $ascDesc) =
                    \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(' ', $orderItem, true);
                if ($ascDesc) {
                    $orderings[$orderField] = ((strtolower($ascDesc) == 'desc') ?
                        \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING :
                        \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                } else {
                    $orderings[$orderField] = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;
                }
            }
        }

        return $orderings;
    }

    /**
     * @param QueryResultInterface $books
     * @param array $uids
     *
     * @return array
     */
    protected function orderByField(QueryResultInterface $books, $uids)
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
