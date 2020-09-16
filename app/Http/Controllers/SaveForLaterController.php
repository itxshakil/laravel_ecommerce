<?php

namespace App\Http\Controllers;

use App\Product;
use App\Helpers\CartHelper;
use Gloudemans\Shoppingcart\Facades\Cart;

class SaveForLaterController extends Controller
{
    use CartHelper;

    private $instance = "savedforlater";

    public function store(Product $product)
    {
        if ($this->isDuplicates($product, $this->instance)) {
            return $this->sendErrorResponse('Item is already saved for later.');
        }

        Cart::instance('savedforlater')->add($product, 1);
        $this->storeCart($this->instance);

        return $this->sendSuccessResponse('Item is saved for later.');
    }

    public function destroy(Product $product)
    {
        Cart::instance('savedforlater');
        Cart::remove($product->cartRowId);
        $this->storeCart($this->instance);

        return $this->sendSuccessResponse('Item is removed from saved for later.');
    }

    public function switchToSaveToCart(Product $product)
    {
        Cart::instance('savedforlater');
        Cart::remove($product->cartRowId);
        $this->storeCart($this->instance);

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->model->id === $product->id;
        });

        if ($duplicates->isNotEmpty()) {
            return $this->sendErrorResponse('Item is already saved in cart.');
        };

        Cart::instance('default')->add($product, 1);
        $this->storeCart();

        return $this->sendSuccessResponse('Item is saved to cart.');
    }
}
