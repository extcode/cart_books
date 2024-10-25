<?php

declare(strict_types=1);

namespace Extcode\CartBooks\Tests\Acceptance;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartBooks\Tests\Acceptance\Support\Tester;

class BookListCest
{
    public function testListForBooks(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/books/');

        $I->see('NSA');
        $I->see('Eschbach, Andreas');
        $I->see('Roman');
        $I->see('1793');
        $I->see('Natt och Dag, Niklas');
        $I->see('Roman');

        $I->dontSee('Book 4');
    }

    public function testShowForAvailableBooks(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/books/');

        $I->see('NSA');

        $I->click('NSA');
        $I->see('NSA', 'h1');
        $I->see('Nationales Sicherheits-Amt', 'h2');
        $I->see('14,90 €');
        $I->see('Eschbach, Andreas');
        $I->see('Roman');

        $I->seeElement("input[name='tx_cart_cart[quantity]']");
        $I->seeElement('input[type="submit"]');
    }

    public function testShowForUnvailableBooks(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/books/');

        $I->see('NSA');

        $I->click('1793');
        $I->see('1793', 'h1');
        $I->see('11,00 €');
        $I->see('Natt och Dag, Niklas');
        $I->see('Roman');

        $I->see('Out of stock');
    }
}
