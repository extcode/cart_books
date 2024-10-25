<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Domain\Model;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Product\StockTrait;
use Extcode\Cart\Domain\Model\Product\TagTrait;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Book extends \Extcode\Books\Domain\Model\Book
{
    use StockTrait;
    use TagTrait;

    #[Validate(['validator' => 'NotEmpty'])]
    protected string $sku = '';

    protected float $price = 0.0;

    protected int $taxClassId = 1;

    /**
     * @var ObjectStorage<SpecialPrice>
     */
    #[Cascade(['value' => 'remove'])]
    protected ObjectStorage $specialPrices;

    public function __construct()
    {
        $this->tags = new ObjectStorage();
        $this->specialPrices = new ObjectStorage();

        parent::__construct();
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getTaxClassId(): int
    {
        return $this->taxClassId;
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

        foreach ($this->getSpecialPrices() as $specialPrice) {
            if ($specialPrice->getPrice() < $bestSpecialPrice) {
                if (!$specialPrice->getFrontendUserGroup() ||
                    in_array($specialPrice->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
                ) {
                    $bestSpecialPrice = $specialPrice->getPrice();
                }
            }
        }

        return $bestSpecialPrice;
    }
}
