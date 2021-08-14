<?php

namespace App\Http\Controllers;

use App\Helpers\CartHelper;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class SaveForLaterController extends Controller
{
    use CartHelper;

    private string $instance = "savedforlater";

    public function store(Product $product): Response|Redirector|RedirectResponse|Application|ResponseFactory
    {
        if ($this->isDuplicates($product, $this->instance)) {
            return $this->sendErrorResponse('Item is already saved for later.');
        }

        Cart::instance($this->instance)->add($product, 1);
        $this->storeCart($this->instance);

        return $this->sendSuccessResponse('Item is saved for later.');
    }

    public function destroy(Product $product): Response|Redirector|Application|RedirectResponse|ResponseFactory
    {
        $this->removeFromCart($product);

        return $this->sendSuccessResponse('Item is removed from saved for later.');
    }

    public function switchToSaveToCart(Product $product): Response|Redirector|RedirectResponse|Application|ResponseFactory
    {
        $this->removeFromCart($product);

        if ($this->isDuplicates($product)) {
            return $this->sendErrorResponse('Item is already saved in cart.');
        }

        Cart::instance('default')->add($product, 1);
        $this->storeCart();

        return $this->sendSuccessResponse('Item is saved to cart.');
    }

    /**
     * @param Product $product
     */
    protected function removeFromCart(Product $product): void
    {
        Cart::instance($this->instance);
        Cart::remove($product->cartRowId);
        $this->storeCart($this->instance);
    }
}
