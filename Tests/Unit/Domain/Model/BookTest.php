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
    public function getSkuReturnsInitialValueForSku()
    {
        $this->assertSame(
            '',
            $this->book->getSku()
        );
    }

    /**
     * @test
     */
    public function setSkuForStringSetsSku()
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
    public function getTitleReturnsInitialValueForTitle()
    {
        $this->assertSame(
            '',
            $this->book->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
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
    public function getSubtitleReturnsInitialValueForSubtitle()
    {
        $this->assertSame(
            '',
            $this->book->getSubtitle()
        );
    }

    /**
     * @test
     */
    public function setSubtitleForStringSetsSubtitle()
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
    public function getAuthorReturnsInitialValueForAuthor()
    {
        $this->assertSame(
            '',
            $this->book->getAuthor()
        );
    }

    /**
     * @test
     */
    public function setAuthorForStringSetsAuthor()
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
    public function getIllustratorReturnsInitialValueForIllustrator()
    {
        $this->assertSame(
            '',
            $this->book->getIllustrator()
        );
    }

    /**
     * @test
     */
    public function setIllustratorForStringSetsIllustrator()
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
    public function getEditorReturnsInitialValueForEditor()
    {
        $this->assertSame(
            '',
            $this->book->getEditor()
        );
    }

    /**
     * @test
     */
    public function setEditorForStringSetsEditor()
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
    public function getPublisherReturnsInitialValueForPublisher()
    {
        $this->assertSame(
            '',
            $this->book->getPublisher()
        );
    }

    /**
     * @test
     */
    public function setPublisherForStringSetsPublisher()
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
    public function getTranslatorReturnsInitialValueForTranslator()
    {
        $this->assertSame(
            '',
            $this->book->getTranslator()
        );
    }

    /**
     * @test
     */
    public function setTranslatorForStringSetsTranslator()
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
    public function getLanguageReturnsInitialValueForLanguage()
    {
        $this->assertSame(
            '',
            $this->book->getLanguage()
        );
    }

    /**
     * @test
     */
    public function setLanguageForStringSetsLanguage()
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
    public function getNumberOfPagesReturnsInitialValueForNumberOfPages()
    {
        $this->assertSame(
            '',
            $this->book->getNumberOfPages()
        );
    }

    /**
     * @test
     */
    public function setNumberOfPagesForStringSetsNumberOfPages()
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
    public function getGenreReturnsInitialValueForGenre()
    {
        $this->assertSame(
            '',
            $this->book->getGenre()
        );
    }

    /**
     * @test
     */
    public function setGenreForStringSetsGenre()
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

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getTeaser()
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForDescription()
    {
        $this->assertSame(
            '',
            $this->book->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->book->setDescription('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->book->getDescription()
        );
    }
}
