<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Domain\Model;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class SpecialPrice extends AbstractEntity
{
    #[Validate(['validator' => 'NotEmpty'])]
    protected string $title = '';

    #[Validate(['validator' => 'NotEmpty'])]
    protected float $price = 0.0;

    protected FrontendUserGroup $frontendUserGroup;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFrontendUserGroup(): ?FrontendUserGroup
    {
        return $this->frontendUserGroup;
    }

    public function setFrontendUserGroup(FrontendUserGroup $frontendUserGroup): self
    {
        $this->frontendUserGroup = $frontendUserGroup;

        return $this;
    }
}
