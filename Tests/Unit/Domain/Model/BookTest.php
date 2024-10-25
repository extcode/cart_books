<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Tests\Unit\Domain\Model;

use Extcode\CartBooks\Domain\Model\Book;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(Book::class)]
class BookTest extends UnitTestCase
{
    protected Book $book;

    protected function setUp(): void
    {
        $this->book = new Book();
    }

    protected function tearDown(): void
    {
        unset($this->book);
    }

    #[Test]
    public function getPriceReturnsInitialValueForPrice(): void
    {
        self::assertSame(
            0.0,
            $this->book->getPrice()
        );
    }

    #[Test]
    public function getPriceReturnsValueForPrice(): void
    {
        $this->setProperty($this->book, 'price', 12.99);

        self::assertSame(
            12.99,
            $this->book->getPrice()
        );
    }

    #[Test]
    public function getSkuReturnsInitialValueForSku(): void
    {
        self::assertSame(
            '',
            $this->book->getSku()
        );
    }

    #[Test]
    public function getSkuReturnsValueForSku(): void
    {
        $this->setProperty($this->book, 'sku', 'Book Sku');

        self::assertSame(
            'Book Sku',
            $this->book->getSku()
        );
    }

    #[Test]
    public function getTaxClassIdReturnsInitialValueForTaxClassId(): void
    {
        self::assertSame(
            1,
            $this->book->getTaxClassId()
        );
    }

    #[Test]
    public function getTaxClassIdReturnsValueForTaxClassId(): void
    {
        $this->setProperty($this->book, 'taxClassId', 2);

        self::assertSame(
            2,
            $this->book->getTaxClassId()
        );
    }

    private function setProperty(object $instance, string $propertyName, mixed $propertyValue)
    {
        $reflection = new \ReflectionProperty($instance, $propertyName);
        $reflection->setAccessible(true);
        $reflection->setValue($instance, $propertyValue);
    }
}
