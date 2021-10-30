<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Model;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    /**
     * @var int
     */
    protected $cartBookListPid;

    /**
     * @var int
     */
    protected $cartBookShowPid;

    public function getCartBookListPid(): ?int
    {
        return $this->cartBookListPid;
    }

    public function getCartBookShowPid(): ?int
    {
        return $this->cartBookShowPid;
    }
}
