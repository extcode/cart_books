<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Domain\Model;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

trait SpecialPriceTrait
{
    /**
     * @var ObjectStorage<SpecialPrice>
     */
    #[Cascade(['value' => 'remove'])]
    protected ObjectStorage $specialPrices;

    public function __construct()
    {
        $this->specialPrices = new ObjectStorage();
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

        foreach ($this->specialPrices as $specialPrice) {
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
