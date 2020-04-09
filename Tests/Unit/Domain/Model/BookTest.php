<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Tests\Domain\Model;

use Extcode\CartBooks\Domain\Model\Book;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BookTest extends UnitTestCase
{
    /**
     * @var Book
     */
    protected $book;

    protected function setUp(): void
    {
        $this->book = new Book();
    }

    protected function tearDown(): void
    {
        unset($this->book);
    }

    /**
     * @test
     */
    public function getSkuReturnsInitialValueForSku(): void
    {
        $this->assertSame(
            '',
            $this->book->getSku()
        );
    }

    /**
     * @test
     */
    public function setSkuForStringSetsSku(): void
    {
        $this->book->setSku('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getSku()
        );
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForTitle(): void
    {
        $this->assertSame(
            '',
            $this->book->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle(): void
    {
        $this->book->setTitle('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getTitle()
        );
    }

    /**
     * @test
     */
    public function getSubtitleReturnsInitialValueForSubtitle(): void
    {
        $this->assertSame(
            '',
            $this->book->getSubtitle()
        );
    }

    /**
     * @test
     */
    public function setSubtitleForStringSetsSubtitle(): void
    {
        $this->book->setSubtitle('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getSubtitle()
        );
    }

    /**
     * @test
     */
    public function getAuthorReturnsInitialValueForAuthor(): void
    {
        $this->assertSame(
            '',
            $this->book->getAuthor()
        );
    }

    /**
     * @test
     */
    public function setAuthorForStringSetsAuthor(): void
    {
        $this->book->setAuthor('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getAuthor()
        );
    }

    /**
     * @test
     */
    public function getIllustratorReturnsInitialValueForIllustrator(): void
    {
        $this->assertSame(
            '',
            $this->book->getIllustrator()
        );
    }

    /**
     * @test
     */
    public function setIllustratorForStringSetsIllustrator(): void
    {
        $this->book->setIllustrator('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getIllustrator()
        );
    }

    /**
     * @test
     */
    public function getEditorReturnsInitialValueForEditor(): void
    {
        $this->assertSame(
            '',
            $this->book->getEditor()
        );
    }

    /**
     * @test
     */
    public function setEditorForStringSetsEditor(): void
    {
        $this->book->setEditor('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getEditor()
        );
    }

    /**
     * @test
     */
    public function getPublisherReturnsInitialValueForPublisher(): void
    {
        $this->assertSame(
            '',
            $this->book->getPublisher()
        );
    }

    /**
     * @test
     */
    public function setPublisherForStringSetsPublisher(): void
    {
        $this->book->setPublisher('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getPublisher()
        );
    }

    /**
     * @test
     */
    public function getTranslatorReturnsInitialValueForTranslator(): void
    {
        $this->assertSame(
            '',
            $this->book->getTranslator()
        );
    }

    /**
     * @test
     */
    public function setTranslatorForStringSetsTranslator(): void
    {
        $this->book->setTranslator('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getTranslator()
        );
    }

    /**
     * @test
     */
    public function getLanguageReturnsInitialValueForLanguage(): void
    {
        $this->assertSame(
            '',
            $this->book->getLanguage()
        );
    }

    /**
     * @test
     */
    public function setLanguageForStringSetsLanguage(): void
    {
        $this->book->setLanguage('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getLanguage()
        );
    }

    /**
     * @test
     */
    public function getNumberOfPagesReturnsInitialValueForNumberOfPages(): void
    {
        $this->assertSame(
            '',
            $this->book->getNumberOfPages()
        );
    }

    /**
     * @test
     */
    public function setNumberOfPagesForStringSetsNumberOfPages(): void
    {
        $this->book->setNumberOfPages('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getNumberOfPages()
        );
    }

    /**
     * @test
     */
    public function getGenreReturnsInitialValueForGenre(): void
    {
        $this->assertSame(
            '',
            $this->book->getGenre()
        );
    }

    /**
     * @test
     */
    public function setGenreForStringSetsGenre(): void
    {
        $this->book->setGenre('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getGenre()
        );
    }

    /**
     * @test
     */
    public function getTeaserReturnsInitialValueForTeaser(): void
    {
        $this->assertSame(
            '',
            $this->book->getTeaser()
        );
    }

    /**
     * @test
     */
    public function setTeaserForStringSetsTeaser(): void
    {
        $this->book->setTeaser('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getTeaser()
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForDescription(): void
    {
        $this->assertSame(
            '',
            $this->book->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription(): void
    {
        $this->book->setDescription('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getDescription()
        );
    }
}
