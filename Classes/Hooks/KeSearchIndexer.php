<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Hooks;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\QueryGenerator;
/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class KeSearchIndexer
{
    public function registerIndexerConfiguration(array &$params, $pObj): void
    {
        $newArray = [
            'Cart Book Indexer',
            'cartbookindexer',
            ExtensionManagementUtility::extPath('cart_books') . 'Resources/Public/Icons/Extension.svg',
        ];
        $params['items'][] = $newArray;
    }

    public function customIndexer(array &$indexerConfig, array &$indexerObject): string
    {
        if ($indexerConfig['type'] === 'cartbookindexer') {
            return $this->cartBookIndexer($indexerConfig, $indexerObject);
        }

        return '';
    }

    public function cartBookIndexer(array &$indexerConfig, array &$indexerObject): string
    {
        $bookIndexerName = 'Book Indexer "' . $indexerConfig['title'] . '"';

        $indexPids = $this->getPidList($indexerConfig);

        if ($indexPids === '') {
            $bookIndexerMessage = 'ERROR: No Storage Pids configured!';
        } else {
            $books = $this->getBooksToIndex($indexPids);

            if ($books) {
                foreach ($books as $book) {
                    // compile the information which should go into the index
                    // the field names depend on the table you want to index!
                    $sku = strip_tags($book['sku']);
                    $title = strip_tags($book['title']);
                    $subtitle = strip_tags($book['subtitle']);
                    $teaser = strip_tags($book['teaser']);
                    $description = strip_tags($book['description']);

                    $fullContent = $sku . "\n" . $title . "\n" . $subtitle . "\n" . $teaser . "\n" . $description;
                    $fullContent .= "\n" . $book['author'];
                    $fullContent .= "\n" . $book['publisher'];
                    $fullContent .= "\n" . $book['genre'];

                    $params = '&tx_cartbooks_books[book]=' . $book['uid'];
                    $tags = '#book#';
                    $additionalFields = [
                        'sortdate' => $book['crdate'],
                        'orig_uid' => $book['uid'],
                        'orig_pid' => $book['pid'],
                    ];

                    $targetPid = $this->getTargetPidFormCategory($book['category']);

                    if ($targetPid == 0) {
                        $targetPid = $indexerConfig['targetpid'];
                    }

                    $indexerObject->storeInIndex(
                        $indexerConfig['storagepid'], // storage PID
                        $title, // record title
                        'cartbook', // content type
                        $targetPid, // target PID: where is the single view?
                        $fullContent, // indexed content, includes the title (linebreak after title)
                        $tags, // tags for faceted search
                        $params, // typolink params for singleview
                        $teaser, // abstract; shown in result list if not empty
                        $book['sys_language_uid'], // language uid
                        $book['starttime'], // starttime
                        $book['endtime'], // endtime
                        $book['fe_group'], // fe_group
                        false, // debug only?
                        $additionalFields // additionalFields
                    );
                }
                $bookIndexerMessage = 'Success: ' . count($books) . ' books has been indexed.';
            } else {
                $bookIndexerMessage = 'Warning: No book found in configured Storage Pids.';
            }
        }

        return '<p><b>' . $bookIndexerName . '</b><br/><strong>' . $bookIndexerMessage . '</strong></p>';
    }

    protected function getPidList(array $config): string
    {
        $recursivePids = $this->extendPidListByChildren($config['startingpoints_recursive'], 99);
        if ($config['sysfolder']) {
            return $recursivePids . ',' . $config['sysfolder'];
        }

        return $recursivePids;
    }

    protected function extendPidListByChildren(string $pidList = '', int $recursive = 0): string
    {
        $recursive = (int)$recursive;

        if ($recursive <= 0) {
            return $pidList;
        }

        $queryGenerator = GeneralUtility::makeInstance(
            QueryGenerator::class
        );
        $recursiveStoragePids = $pidList;
        $storagePids = GeneralUtility::intExplode(',', $pidList);
        foreach ($storagePids as $startPid) {
            $pids = $queryGenerator->getTreeList($startPid, $recursive, 0, 1);
            if (strlen($pids) > 0) {
                $recursiveStoragePids .= ',' . $pids;
            }
        }

        return $recursiveStoragePids;
    }

    protected function getBooksToIndex(string $indexPids): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_cartbooks_domain_model_book');

        $queryBuilder
            ->select('*')
            ->from('tx_cartbooks_domain_model_book')
            ->where(
                $queryBuilder->expr()->in('tx_cartbooks_domain_model_book.pid', $indexPids)
            );

        return $queryBuilder->execute()->fetchAll();
    }

    protected function getTargetPidFormCategory($categoryUid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_category');

        $constraints = [
            $queryBuilder->expr()->eq('sys_category_mm.tablenames', $queryBuilder->createNamedParameter('tx_cartbooks_domain_model_book', \PDO::PARAM_STR)),
            $queryBuilder->expr()->eq('sys_category_mm.fieldname', $queryBuilder->createNamedParameter('category', \PDO::PARAM_STR)),
            $queryBuilder->expr()->eq('sys_category_mm.uid_foreign', $queryBuilder->createNamedParameter($categoryUid, \PDO::PARAM_INT)),
        ];

        $queryBuilder
            ->select('sys_category.cart_book_show_pid')
            ->from('sys_category')
            ->leftJoin(
                'sys_category',
                'sys_category_record_mm',
                'sys_category_mm',
                $queryBuilder->expr()->eq(
                    'sys_category_mm.uid_local',
                    $queryBuilder->quoteIdentifier('sys_category.uid')
                )
            )
            ->where(...$constraints);

        $sysCategory = $queryBuilder->execute()->fetch();

        return $sysCategory['cart_book_show_pid'];
    }
}
