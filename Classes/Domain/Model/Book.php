<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $images;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
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
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\SpecialPrice>
     */
    protected $specialPrices;

    /**
     * @var \Extcode\CartBooks\Domain\Model\Category
     */
    protected $category;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\Category>
     */
    protected $categories;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\Cart\Domain\Model\Tag>
     */
    protected $tags;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\Book>
     */
    protected $relatedBooks = null;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\Book>
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

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle(string $subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getIllustrator(): string
    {
        return $this->illustrator;
    }

    /**
     * @param string $illustrator
     */
    public function setIllustrator(string $illustrator)
    {
        $this->illustrator = $illustrator;
    }

    /**
     * @return string
     */
    public function getEditor(): string
    {
        return $this->editor;
    }

    /**
     * @param string $editor
     */
    public function setEditor(string $editor)
    {
        $this->editor = $editor;
    }

    /**
     * @return string
     */
    public function getPublisher(): string
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     */
    public function setPublisher(string $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return string
     */
    public function getTranslator(): string
    {
        return $this->translator;
    }

    /**
     * @param string $translator
     */
    public function setTranslator(string $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getNumberOfPages(): string
    {
        return $this->numberOfPages;
    }

    /**
     * @param string $numberOfPages
     */
    public function setNumberOfPages(string $numberOfPages)
    {
        $this->numberOfPages = $numberOfPages;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfPublication(): \DateTime
    {
        return $this->dateOfPublication;
    }

    /**
     * @param \DateTime $dateOfPublication
     */
    public function setDateOfPublication(\DateTime $dateOfPublication)
    {
        $this->dateOfPublication = $dateOfPublication;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre(string $genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getTeaser(): string
    {
        return $this->teaser;
    }

    /**
     * @param string $teaser
     */
    public function setTeaser(string $teaser)
    {
        $this->teaser = $teaser;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Returns the Images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Returns the first Image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getFirstImage()
    {
        return array_shift($this->getImages()->toArray());
    }

    /**
     * Sets the Images
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * Returns the Files
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the Files
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Returns the Special Prices
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\SpecialPrice>
     */
    public function getSpecialPrices()
    {
        return $this->specialPrices;
    }

    /**
     * Adds a Special Price
     *
     * @param \Extcode\CartBooks\Domain\Model\SpecialPrice $specialPrice
     */
    public function addSpecialPrice(\Extcode\CartBooks\Domain\Model\SpecialPrice $specialPrice)
    {
        $this->specialPrices->attach($specialPrice);
    }

    /**
     * Removes a Special Price
     *
     * @param \Extcode\CartBooks\Domain\Model\SpecialPrice $specialPrice
     */
    public function removeSpecialPrice(\Extcode\CartBooks\Domain\Model\SpecialPrice $specialPrice)
    {
        $this->specialPrices->detach($specialPrice);
    }

    /**
     * Sets the Special Prices
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $specialPrices
     */
    public function setSpecialPrices(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $specialPrices)
    {
        $this->specialPrices = $specialPrices;
    }

    /**
     * Returns best Special Price
     *
     * @var array
     * @param mixed $frontendUserGroupIds
     * @return float
     */
    public function getBestSpecialPrice($frontendUserGroupIds = [])
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

    /**
     * @return bool
     */
    public function isHandleStock(): bool
    {
        return $this->handleStock;
    }

    /**
     * @param bool $handleStock
     */
    public function setHandleStock(bool $handleStock)
    {
        $this->handleStock = $handleStock;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return \Extcode\CartBooks\Domain\Model\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param \Extcode\CartBooks\Domain\Model\Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags
     */
    public function setTags(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param \Extcode\CartBooks\Domain\Model\Book $relatedBook
     */
    public function addRelatedBook(\Extcode\CartBooks\Domain\Model\Book $relatedBook)
    {
        $this->relatedBooks->attach($relatedBook);
    }

    /**
     * @param \Extcode\CartBooks\Domain\Model\Book $relatedBook
     */
    public function removeRelatedBook(\Extcode\CartBooks\Domain\Model\Book $relatedBook)
    {
        $this->relatedBooks->detach($relatedBook);
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\Book> $relatedBook
     */
    public function getRelatedBooks()
    {
        return $this->relatedBooks;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\Book> $relatedBooks
     */
    public function setRelatedBooks(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $relatedBooks)
    {
        $this->relatedBooks = $relatedBooks;
    }

    /**
     * @param \Extcode\CartBooks\Domain\Model\Book $relatedBookFrom
     */
    public function addRelatedBookFrom(\Extcode\CartBooks\Domain\Model\Book $relatedBookFrom)
    {
        $this->relatedBooksFrom->attach($relatedBookFrom);
    }

    /**
     * @param \Extcode\CartBooks\Domain\Model\Book $relatedBookFrom
     */
    public function removeRelatedBookFrom(\Extcode\CartBooks\Domain\Model\Book $relatedBookFrom)
    {
        $this->relatedBooksFrom->detach($relatedBookFrom);
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\Book> $relatedBookFrom
     */
    public function getRelatedBooksFrom()
    {
        return $this->relatedBooksFrom;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartBooks\Domain\Model\Book> $relatedBooksFrom
     */
    public function setRelatedBooksFrom(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $relatedBooksFrom)
    {
        $this->relatedBooksFrom = $relatedBooksFrom;
    }

    /**
     * @return int
     */
    public function getTaxClassId(): int
    {
        return $this->taxClassId;
    }

    /**
     * @param int $taxClassId
     */
    public function setTaxClassId(int $taxClassId)
    {
        $this->taxClassId = $taxClassId;
    }

    /**
     * Returns MetaDescription
     *
     * @return string $metaDescription
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Sets MetaDescription
     *
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }
}
