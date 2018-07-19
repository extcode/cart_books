<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Model;

/**
 * Category Model
 *
 * @author Daniel Lorenz <ext.cart@extco.de>
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    /**
     * Cart Book List Pid
     *
     * @var int
     */
    protected $cartBookListPid;

    /**
     * Cart Book Single Pid
     *
     * @var int
     */
    protected $cartBookShowPid;

    /**
     * Returns Cart Book List Pid
     *
     * @return int
     */
    public function getCartBookListPid()
    {
        return $this->cartBookListPid;
    }

    /**
     * Returns Cart Book Single Pid
     *
     * @return int
     */
    public function getcartBookShowPid()
    {
        return $this->cartBookShowPid;
    }
}
