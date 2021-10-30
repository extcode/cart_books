<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Model;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Tag;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Book extends AbstractEntity
{
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $sku = '';

    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $subtitle = '';

    /**
     * @var string
     */
    protected $isbn10 = '';

    /**
     * @var string
     */
    protected $isbn13 = '';

    /**
     * @var string
     */
    protected $issn = '';

    /**
     * @var string
     */
    protected $author = '';

    /**
     * @var string
     */
    protected $illustrator = '';

    /**
     * @var string
     */
    protected $editor = '';

    /**
     * @var string
     */
    protected $publisher = '';

    /**
     * @var string
     */
    protected $translator = '';

    /**
     * @var string
     */
    protected $language = '';

    /**
     * @var string
     */
    protected $numberOfPages = '';

    /**
     * @var \DateTime
     */
    protected $dateOfPublication;

    /**
     * @var string
     */
    protected $genre = '';

    /**
     * @var string
     */
    protected $teaser = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var ObjectStorage<FileReference>
     */
    protected $images;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected $files;

    /**
     * @var float
     */
    protected $price = 0.0;

    /**
     * @var bool
     */
    protected $handleStock = false;

    /**
     * @var int
     */
    protected $stock = 0;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var ObjectStorage<SpecialPrice>
     */
    protected $specialPrices;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var ObjectStorage<Category>
     */
    protected $categories;

    /**
     * @var ObjectStorage<Tag>
     */
    protected $tags;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var ObjectStorage<Book>
     */
    protected $relatedBooks;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var ObjectStorage<Book>
     */
    protected $relatedBooksFrom;

    /**
     * @var int
     */
    protected $taxClassId = 1;

    /**
     * @var string
     */
    protected $metaDescription = '';

    public function __construct()
    {
        $this->files = new ObjectStorage();
        $this->images = new ObjectStorage();
        $this->specialPrices = new ObjectStorage();
        $this->relatedBooks = new ObjectStorage();
        $this->relatedBooksFrom = new ObjectStorage();
        $this->categories = new ObjectStorage();
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
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
        $this->isbn10 = $isbn13;
    }

    public function getIssn(): string
    {
        return $this->issn;
    }

    public function setIssn(string $issn): void
    {
        $this->isbn10 = $issn;
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

    public function getTeaser(): string
    {
        return $this->teaser;
    }

    public function setTeaser(string $teaser): void
    {
        $this->teaser = $teaser;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImages(): ObjectStorage
    {
        return $this->images;
    }

    public function getFirstImage(): ?FileReference
    {
        $images = $this->getImages()->toArray();
        return array_shift($images);
    }

    public function setImages(ObjectStorage $images): void
    {
        $this->images = $images;
    }

    public function getFiles(): ObjectStorage
    {
        return $this->files;
    }

    public function setFiles(ObjectStorage $files): void
    {
        $this->files = $files;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getSpecialPrices(): ObjectStorage
    {
        return $this->specialPrices;
    }

    public function addSpecialPrice(SpecialPrice $specialPrice): void
    {
        $this->specialPrices->attach($specialPrice);
    }

    public function removeSpecialPrice(SpecialPrice $specialPrice): void
    {
        $this->specialPrices->detach($specialPrice);
    }

    public function setSpecialPrices(ObjectStorage $specialPrices): void
    {
        $this->specialPrices = $specialPrices;
    }

    public function getBestSpecialPrice(array $frontendUserGroupIds = []): float
    {
        $bestSpecialPrice = $this->price;

        if ($this->specialPrices) {
            foreach ($this->specialPrices as $specialPrice) {
                if ($specialPrice->getPrice() < $bestSpecialPrice) {
                    if (!$specialPrice->getFrontendUserGroup() ||
                        in_array($specialPrice->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
                    ) {
                        $bestSpecialPrice = $specialPrice->getPrice();
                    }
                }
            }
        }

        return $bestSpecialPrice;
    }

    public function isHandleStock(): bool
    {
        return $this->handleStock;
    }

    public function setHandleStock(bool $handleStock): void
    {
        $this->handleStock = $handleStock;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    public function getTags(): ObjectStorage
    {
        return $this->tags;
    }

    public function setTags(ObjectStorage $tags): void
    {
        $this->tags = $tags;
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
