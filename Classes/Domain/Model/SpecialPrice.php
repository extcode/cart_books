<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Model;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;

class SpecialPrice extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * @var float
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $price = 0.0;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
     */
    protected $frontendUserGroup = null;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return SpecialPrice
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return float $price
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Sets the Price
     *
     * @param float $price
     *
     * @return SpecialPrice
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return null|FrontendUserGroup
     */
    public function getFrontendUserGroup(): ?FrontendUserGroup
    {
        return $this->frontendUserGroup;
    }

    /**
     * @param FrontendUserGroup $frontendUserGroup
     *
     * @return SpecialPrice
     */
    public function setFrontendUserGroup(FrontendUserGroup $frontendUserGroup): self
    {
        $this->frontendUserGroup = $frontendUserGroup;

        return $this;
    }
}
