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
     * @param string $action Target action
     * @param array $arguments Arguments
     * @param string $controller Target controller. If NULL current controllerName is used
     * @param string $extensionName Target Extension Name (without "tx_" prefix and no underscores). If NULL the current extension name is used
     * @param string $pluginName Target plugin. If empty, the current plugin name is used
     * @param int $pageUid target page. See TypoLink destination
     * @param int $pageType type of the target page. See typolink.parameter
     * @param bool $noCache set this to disable caching for the target page. You should not need this.
     * @param bool $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
     * @param string $section the anchor to be added to the URI
     * @param string $format The requested format, e.g. ".html
     * @param bool $linkAccessRestrictedPages if set, links pointing to access restricted pages will still link to the page even though the page cannot be accessed
     * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
     * @param bool $absolute If set, the URI of the rendered link is absolute
     * @param bool $addQueryString If set, the current query parameters will be kept in the URI
     * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = true
     * @param string $addQueryStringMethod Set which parameters will be kept. Only active if $addQueryString = true
     * @return string Rendered link
     */
    public function render(
        $action = null,
        array $arguments = [],
        $controller = null,
        $extensionName = null,
        $pluginName = null,
        $pageUid = null,
        $pageType = 0,
        $noCache = false,
        $noCacheHash = false,
        $section = '',
        $format = '',
        $linkAccessRestrictedPages = false,
        array $additionalParams = [],
        $absolute = false,
        $addQueryString = false,
        array $argumentsToBeExcludedFromQueryString = [],
        $addQueryStringMethod = null
    ) {
        $book = $this->arguments['book'];

        if ($book->getCategory() && $book->getCategory()->getCartBookShowPid()) {
            $pageUid = $book->getCategory()->getCartBookShowPid();
        } elseif ($this->arguments['settings']['showPageUids']) {
            $pageUid = $this->arguments['settings']['showPageUids'];
        }

        $action = 'show';
        $arguments = [
            'book' => $book,
        ];

        return parent::render(
            $action,
            $arguments,
            $controller,
            $extensionName,
            $pluginName,
            $pageUid,
            $pageType,
            $noCache,
            $noCacheHash,
            $section,
            $format,
            $linkAccessRestrictedPages,
            $additionalParams,
            $absolute,
            $addQueryString,
            $argumentsToBeExcludedFromQueryString,
            $addQueryStringMethod
        );
    }
}
