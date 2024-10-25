<?php

declare(strict_types=1);

namespace Extcode\CartBooks\EventListener\View;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Books\Event\View\ModifyViewEvent;
use Extcode\Cart\Domain\Model\Cart\Cart;
use Extcode\Cart\Service\SessionHandler;
use Extcode\Cart\Utility\CartUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

final class ModifyView
{
    private array $cartConfiguration;

    public function __construct(
        private readonly SessionHandler $sessionHandler,
        private readonly CartUtility $cartUtility,
        ConfigurationManager $configurationManager,
    ) {
        $this->cartConfiguration = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'Cart'
        );
    }

    public function __invoke(ModifyViewEvent $event): void
    {
        $view = $event->getView();

        $cart = $this->restoreCart();

        $currencyTranslationData = [
            'currencyCode' => $cart->getCurrencyCode(),
            'currencySign' => $cart->getCurrencySign(),
            'currencyTranslation' => $cart->getCurrencyTranslation(),
        ];

        $view->assign('currencyTranslationData', $currencyTranslationData);
    }

    private function restoreCart(): Cart
    {
        $cart = $this->sessionHandler->restoreCart($this->cartConfiguration['settings']['cart']['pid']);

        if ($cart instanceof Cart) {
            return $cart;
        }

        $cart = $this->cartUtility->getNewCart($this->cartConfiguration);
        $this->sessionHandler->writeCart($this->cartConfiguration['settings']['cart']['pid'], $cart);

        return $cart;
    }
}
