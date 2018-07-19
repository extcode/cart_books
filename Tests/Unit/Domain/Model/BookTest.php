<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Tests\Domain\Model;

use Nimut\TestingFramework\TestCase\UnitTestCase;

class BookTest extends UnitTestCase
{
    /**
     * Book
     *
     * @var \Extcode\CartBooks\Domain\Model\Book
     */
    protected $book = null;

    protected function setUp()
    {
        $this->book = new \Extcode\CartBooks\Domain\Model\Book();
    }

    protected function tearDown()
    {
        unset($this->book);
    }

    /**
     * @test
     */
    public function getTeaserReturnsInitialValueForTeaser()
    {
        $this->assertSame(
            '',
            $this->book->getTeaser()
        );
    }

    /**
     * @test
     */
    public function setTeaserForStringSetsTeaser()
    {
        $this->book->setTeaser('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'teaser',
            $this->book
        );
    }
}
