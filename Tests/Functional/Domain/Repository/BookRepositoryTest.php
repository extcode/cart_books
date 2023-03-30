<?php

namespace Extcode\CartBooks\Tests\Functional\Domain\Repository;

/*
 * This file is part of the package extcode/cart.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Codappix\Typo3PhpDatasets\TestingFramework;
use Extcode\CartBooks\Domain\Model\Book;
use Extcode\CartBooks\Domain\Model\Dto\BookDemand;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class BookRepositoryTest extends FunctionalTestCase
{
    use TestingFramework;

    protected BookRepository $bookRepository;

    public function setUp(): void
    {
        $this->testExtensionsToLoad[] = 'extcode/cart';
        $this->testExtensionsToLoad[] = 'extcode/cart-books';

        parent::setUp();

        $this->bookRepository = GeneralUtility::makeInstance(BookRepository::class);

        $this->importPHPDataSet(__DIR__ . '/../../../Fixtures/PagesDatabase.php');
        $this->importPHPDataSet(__DIR__ . '/../../../Fixtures/BooksDatabase.php');
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
            3,
            $books->count()
        );
    }

    /**
     * @test
     */
    public function findDemandedBySku(): void
    {
        $demand = new BookDemand();
        $demand->setSku('9783404179008');

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
