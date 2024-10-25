.. include:: ../../Includes.rst.txt

=============
Configuration
=============

.. code-block:: typoscript
   :caption: EXT:cart-books/Configuration/TypoScript/setup.typoscript

    plugin.tx_cartbooks {
        settings {
            cart {
                pid = {$plugin.tx_cart.settings.cart.pid}
                isNetCart = {$plugin.tx_cart.settings.cart.isNetCart}
            }

            order {
                pid = {$plugin.tx_cart.settings.order.pid}
            }

            format.currency < plugin.tx_cart.settings.format.currency

            addToCartByAjax = {$plugin.tx_cart.settings.addToCartByAjax}
        }
    }

.. container:: table-row

   Property
      plugin.tx_cartbooks.settings.format.currency
   Data type
      array
   Description
      Configures how prices should be formated in frontend. The \Extcode\Cart\ViewHelpers\Format\CurrencyViewHelper use
      this global setting.
   Default
      The TypoScript template copy the setting from settings of the cart extension.

.. container:: table-row

   Property
      plugin.tx_cartbooks.settings.addToCartByAjax
   Data type
      int
   Description
      Activates the option to add books via AJAX action. There is no forwarding to the shopping cart page.
      The response can used to display messages or update the MiniCart-Plugin.
   Default
      The TypoScript template use the setting defined by the constant of the cart extension.
