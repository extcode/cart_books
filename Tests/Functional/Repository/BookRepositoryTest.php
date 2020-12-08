<?php

namespace Extcode\CartBooks\Tests\Functional\Repository;

/*
 * This file is part of the package extcode/cart.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartBooks\Domain\Model\Dto\BookDemand;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class BookRepositoryTest extends FunctionalTestCase
{
    /**
     * @var BookRepository
     */
    protected $bookRepository;

    protected $testExtensionsToLoad = [
        'typo3conf/ext/cart',
        'typo3conf/ext/cart_books'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->bookRepository = GeneralUtility::makeInstance(BookRepository::class);

        $this->importDataSet(__DIR__ . '/../Fixtures/pages.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_cartbooks_domain_model_book.xml');
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
        $address = $this->bookRepository->findByUid(1);
        $this->assertSame(
            'NSA',
            $address->getTitle()
        );
        $this->assertSame(
            'Nationales Sicherheits-Amt',
            $address->getSubtitle()
        );
    }

    /**
     * @test
     */
    public function findAllRecords(): void
    {
        $addresses = $this->bookRepository->findAll();
        $this->assertSame(
            0,
            $addresses->count()
        );

        $querySettings = $this->bookRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->bookRepository->setDefaultQuerySettings($querySettings);
        $addresses = $this->bookRepository->findAll();
        $this->assertSame(
            2,
            $addresses->count()
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

        $this->assertCount(
            1,
            $books
        );

        $this->assertSame(
            'NSA',
            $books->getFirst()->getTitle()
        );
    }
}
