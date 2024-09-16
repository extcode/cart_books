<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Domain\Model;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Product\AbstractProduct;
use Extcode\Cart\Domain\Model\Product\CategoryTrait;
use Extcode\Cart\Domain\Model\Product\FileAndImageTrait;
use Extcode\Cart\Domain\Model\Product\StockTrait;
use Extcode\Cart\Domain\Model\Product\TagTrait;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Book extends AbstractProduct
{
    use CategoryTrait;
    use FileAndImageTrait;
    use SpecialPriceTrait;
    use StockTrait;
    use TagTrait;

    protected string $subtitle = '';

    protected string $isbn10 = '';

    protected string $isbn13 = '';

    protected string $issn = '';

    protected string $author = '';

    protected string $illustrator = '';

    protected string $editor = '';

    protected string $publisher = '';

    protected string $translator = '';

    protected string $language = '';

    protected string $numberOfPages = '';

    protected \DateTime $dateOfPublication;

    protected string $genre = '';

    protected float $price = 0.0;

    /**
     * @var ObjectStorage<Book>
     */
    #[Lazy]
    protected ObjectStorage $relatedBooks;

    /**
     * @var ObjectStorage<Book>
     */
    #[Lazy]
    protected ObjectStorage $relatedBooksFrom;

    protected int $taxClassId = 1;

    protected string $metaDescription = '';

    public function __construct()
    {
        $this->relatedBooks = new ObjectStorage();
        $this->relatedBooksFrom = new ObjectStorage();
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public function getIsbn10(): string
    {
        return $this->isbn10;
    }

    public function setIsbn10(string $isbn10): void
    {
        $this->isbn10 = $isbn10;
    }

    public function getIsbn13(): string
    {
        return $this->isbn13;
    }

    public function setIsbn13(string $isbn13): void
    {
        $this->isbn13 = $isbn13;
    }

    public function getIssn(): string
    {
        return $this->issn;
    }

    public function setIssn(string $issn): void
    {
        $this->issn = $issn;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getIllustrator(): string
    {
        return $this->illustrator;
    }

    public function setIllustrator(string $illustrator): void
    {
        $this->illustrator = $illustrator;
    }

    public function getEditor(): string
    {
        return $this->editor;
    }

    public function setEditor(string $editor): void
    {
        $this->editor = $editor;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getTranslator(): string
    {
        return $this->translator;
    }

    public function setTranslator(string $translator): void
    {
        $this->translator = $translator;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getNumberOfPages(): string
    {
        return $this->numberOfPages;
    }

    public function setNumberOfPages(string $numberOfPages): void
    {
        $this->numberOfPages = $numberOfPages;
    }

    public function getDateOfPublication(): \DateTime
    {
        return $this->dateOfPublication;
    }

    public function setDateOfPublication(\DateTime $dateOfPublication): void
    {
        $this->dateOfPublication = $dateOfPublication;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getRelatedBooks(): ObjectStorage
    {
        return $this->relatedBooks;
    }

    public function addRelatedBook(self $relatedBook): void
    {
        $this->relatedBooks->attach($relatedBook);
    }

    public function removeRelatedBook(self $relatedBook): void
    {
        $this->relatedBooks->detach($relatedBook);
    }

    public function setRelatedBooks(ObjectStorage $relatedBooks): void
    {
        $this->relatedBooks = $relatedBooks;
    }

    public function getRelatedBooksFrom(): ObjectStorage
    {
        return $this->relatedBooksFrom;
    }

    public function addRelatedBookFrom(self $relatedBookFrom): void
    {
        $this->relatedBooksFrom->attach($relatedBookFrom);
    }

    public function removeRelatedBookFrom(self $relatedBookFrom): void
    {
        $this->relatedBooksFrom->detach($relatedBookFrom);
    }

    public function setRelatedBooksFrom(ObjectStorage $relatedBooksFrom): void
    {
        $this->relatedBooksFrom = $relatedBooksFrom;
    }

    public function getTaxClassId(): int
    {
        return $this->taxClassId;
    }

    public function setTaxClassId(int $taxClassId): void
    {
        $this->taxClassId = $taxClassId;
    }

    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }
}
