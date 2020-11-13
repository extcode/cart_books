<?php
declare(strict_types=1);
namespace Extcode\CartBooks\ViewHelpers\Link;

/*
 * This file is part of the package extcode/cart_books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

class BookViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Link\ActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('book', \Extcode\CartBooks\Domain\Model\Book::class, 'book', true);
        $this->registerArgument('settings', 'array', 'settings array', true);
    }

    /**
     * @return string Rendered link
     */
    public function render()
    {
        $book = $this->arguments['book'];

        if ($book->getCategory() && $book->getCategory()->getCartBookShowPid()) {
            $this->arguments['pluginName'] = 'SingleBook';
            $this->arguments['pageUid'] = $book->getCategory()->getCartBookShowPid();
        } elseif ($this->arguments['settings']['showPageUid']) {
            $this->arguments['pluginName'] = 'SingleBook';
            $this->arguments['pageUid'] = $this->arguments['settings']['showPageUid'];
        } else {
            $this->arguments['pluginName'] = 'Books';
        }

        $this->arguments['action'] = 'show';
        $this->arguments['arguments']['book'] = $book;

        return parent::render();
    }
}
