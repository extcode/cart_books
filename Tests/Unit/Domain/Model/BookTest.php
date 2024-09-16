<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Tests\Unit\Domain\Model;

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
    public function getSubtitleReturnsInitialValueForSubtitle(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getSubtitle()
        );
    }

    /**
     * @test
     */
    public function getAuthorReturnsInitialValueForAuthor(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getAuthor()
        );
    }

    /**
     * @test
     */
    public function getIllustratorReturnsInitialValueForIllustrator(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getIllustrator()
        );
    }

    /**
     * @test
     */
    public function getEditorReturnsInitialValueForEditor(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getEditor()
        );
    }

    /**
     * @test
     */
    public function getPublisherReturnsInitialValueForPublisher(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getPublisher()
        );
    }

    /**
     * @test
     */
    public function getTranslatorReturnsInitialValueForTranslator(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getTranslator()
        );
    }

    /**
     * @test
     */
    public function getLanguageReturnsInitialValueForLanguage(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getLanguage()
        );
    }

    /**
     * @test
     */
    public function getNumberOfPagesReturnsInitialValueForNumberOfPages(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getNumberOfPages()
        );
    }

    /**
     * @test
     */
    public function getGenreReturnsInitialValueForGenre(): void
    {
        self::assertSame(
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

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getGenre()
        );
    }

    /**
     * @test
     */
    public function getIsbn10ReturnsInitialValueForIsbn10(): void
    {
        self::assertSame(
            '',
            $this->book->getIsbn10()
        );
    }

    /**
     * @test
     */
    public function setIsbn10ForStringSetsIsbn10(): void
    {
        $this->book->setIsbn10('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getIsbn10()
        );
    }

    /**
     * @test
     */
    public function getIsbn13ReturnsInitialValueForIsbn13(): void
    {
        self::assertSame(
            '',
            $this->book->getIsbn13()
        );
    }

    /**
     * @test
     */
    public function setIsbn13ForStringSetsIsbn13(): void
    {
        $this->book->setIsbn13('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getIsbn13()
        );
    }

    /**
     * @test
     */
    public function getIssnReturnsInitialValueForIssn(): void
    {
        self::assertSame(
            '',
            $this->book->getIssn()
        );
    }

    /**
     * @test
     */
    public function setIssnForStringSetsIssn(): void
    {
        $this->book->setIssn('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->book->getIssn()
        );
    }
}
