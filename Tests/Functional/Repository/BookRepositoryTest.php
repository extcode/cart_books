<?php

namespace Extcode\CartBooks\Tests\Functional\Repository;

/*
 * This file is part of the package extcode/cart.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartBooks\Domain\Model\Book;
use Extcode\CartBooks\Domain\Model\Dto\BookDemand;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class BookRepositoryTest extends FunctionalTestCase
{
    protected BookRepository $bookRepository;

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/cart',
        'typo3conf/ext/cart_books',
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = GeneralUtility::makeInstance(BookRepository::class);

        $this->importCSVDataSet(__DIR__ . '/../Fixtures/pages.csv');
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/tx_cartbooks_domain_model_book.csv');
    }

    public function tearDown(): void
    {
        unset($this->bookRepository);
    }

    /**
     * @test
     */
    public function findRecordsByUid(): void
    {
        $book = $this->bookRepository->findByUid(1);

        self::assertInstanceOf(
            Book::class,
            $book
        );

        self::assertSame(
            'NSA',
            $book->getTitle()
        );
        self::assertSame(
            'Nationales Sicherheits-Amt',
            $book->getSubtitle()
        );
    }

    /**
     * @test
     */
    public function findAllRecords(): void
    {
        $books = $this->bookRepository->findAll();
        self::assertSame(
            0,
            $books->count()
        );

        $querySettings = $this->bookRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->bookRepository->setDefaultQuerySettings($querySettings);
        $books = $this->bookRepository->findAll();
        self::assertSame(
            2,
            $books->count()
        );
    }

    /**
     * @test
     */
    public function findDemandedBySku(): void
    {
        $demand = new BookDemand();
        $demand->setSku('9783785726259');

        $querySettings = $this->bookRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->bookRepository->setDefaultQuerySettings($querySettings);
        $books = $this->bookRepository->findDemanded($demand);

        self::assertCount(
            1,
            $books
        );

        self::assertSame(
            'NSA',
            $books->getFirst()->getTitle()
        );
    }
}
