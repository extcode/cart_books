<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Tests\Unit\EventListener;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\Cart;
use Extcode\Cart\Event\RetrieveProductsFromRequestEvent;
use Extcode\CartBooks\Domain\Repository\BookRepository;
use Extcode\CartBooks\EventListener\RetrieveProductsFromRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Localization\Locale;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(RetrieveProductsFromRequest::class)]
class RetrieveProductsFromRequestTest extends UnitTestCase
{
    protected bool $resetSingletonInstances = true;

    #[Test]
    public function ignoresRequestsForOtherProductTypes(): void
    {
        $event = $this->createEvent(['productType' => 'CartProducts']);

        $this->createSubject()($event);

        self::assertSame([], $event->getErrors());
        self::assertSame([], $event->getProducts());
    }

    #[Test]
    public function setsErrorAsFlashMessageForMissingBookArgument(): void
    {
        $event = $this->createEvent(['productType' => 'CartBooks', 'book' => '0', 'quantity' => '1']);

        $this->mockTranslation();
        $this->createSubject()($event);

        $this->assertSingleError($event, 'tx_cartbooks.error.book_not_found', ContextualFeedbackSeverity::ERROR);
    }

    #[Test]
    public function setsErrorAsFlashMessageForInvalidQuantity(): void
    {
        $event = $this->createEvent(['productType' => 'CartBooks', 'book' => '1', 'quantity' => '-1']);

        $this->mockTranslation();
        $this->createSubject()($event);

        $this->assertSingleError($event, 'tx_cartbooks.error.invalid_quantity', ContextualFeedbackSeverity::WARNING);
    }

    #[Test]
    public function setsErrorAsFlashMessageForNotExistingBook(): void
    {
        $event = $this->createEvent(['productType' => 'CartBooks', 'book' => '42', 'quantity' => '1']);

        $bookRepository = self::createStub(BookRepository::class);
        $bookRepository->method('findByUid')->willReturn(null);

        $this->mockTranslation();
        (new RetrieveProductsFromRequest($bookRepository))($event);

        $this->assertSingleError($event, 'tx_cartbooks.error.book_not_found', ContextualFeedbackSeverity::ERROR);
        self::assertSame([], $event->getProducts());
    }

    /**
     * Lets LocalizationUtility::translate() return the given key.
     */
    private function mockTranslation(): void
    {
        $locales = self::createStub(Locales::class);
        $locales->method('createLocaleFromRequest')->willReturn(new Locale());
        GeneralUtility::setSingletonInstance(Locales::class, $locales);

        $languageService = self::createStub(LanguageService::class);
        $languageService->method('translate')->willReturnArgument(0);
        $languageServiceFactory = self::createStub(LanguageServiceFactory::class);
        $languageServiceFactory->method('create')->willReturn($languageService);
        GeneralUtility::addInstance(LanguageServiceFactory::class, $languageServiceFactory);
    }

    /**
     * @param array<string, string> $arguments
     */
    private function createEvent(array $arguments): RetrieveProductsFromRequestEvent
    {
        $request = self::createStub(RequestInterface::class);
        $request->method('getArguments')->willReturn($arguments);

        $cart = self::createStub(Cart::class);
        $cart->method('getTaxClasses')->willReturn([]);

        return new RetrieveProductsFromRequestEvent($request, $cart);
    }

    private function createSubject(): RetrieveProductsFromRequest
    {
        return new RetrieveProductsFromRequest(self::createStub(BookRepository::class));
    }

    private function assertSingleError(
        RetrieveProductsFromRequestEvent $event,
        string $message,
        ContextualFeedbackSeverity $severity
    ): void {
        $errors = $event->getErrors();

        self::assertCount(1, $errors);
        self::assertSame($message, $errors[0]->getMessage());
        self::assertSame($severity, $errors[0]->getSeverity());
    }
}
