<?php

namespace App\Http\Controllers;

use App\Product;
use App\Library\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $product;
    private $shippingMethod;
    private $relatedProduct;
    private $cartService;

    public function __construct (Product $product, CartService $cartService)
    {
        $this->product = $product;
        $this->cartService = $cartService;

        $this->middleware('auth')->except('logout');
    }

    public function post (Request $request)
    {
        if (isset($request->input)) {
            $request->validate([
                'input' => 'string|min:5|max:30'
            ]);
            if ($request->input == 'emptyCart') {
                return view('empty-cart');
            } elseif ($request->get('input') == 'removeRow') {

                $productId = $request->get('productId');

                if ($request->session()->has('cartProducts')) {

                    $cartProducts = $request->session()->get('cartProducts');

                    if (array_key_exists($productId, $cartProducts)) {

                        unset($cartProducts[$productId]);
                        if (count($cartProducts) <= 2) {
                            $request->session()->forget('cartProducts');
                            return ['items' => 0, 'total' => 0];
                        }
                        $cartProducts['total'] = $request->get('subtotal');
                        $request->session()->forget('cartProducts');
                        $request->session()->put('cartProducts', $cartProducts);
                    }
                    return ['items' => (count($cartProducts) - 2), 'total' => $cartProducts['total']];
                }
                return 0;
            } elseif ($request->get('input') == 'changeShipping') {

                if ($request->session()->has('cartProducts')) {

                    $cartProducts = $request->session()->get('cartProducts');

                    if (array_key_exists('total', $cartProducts)) {
                        $cartProducts['total'] = $request->subtotal;
                        $cartProducts['shippingMethodId'] = $request->shippingMethodId;
                        $request->session()->forget('cartProducts');
                        $request->session()->put('cartProducts', $cartProducts);
                    }
                    return ['items' => (count($cartProducts) - 2), 'total' => $cartProducts['total']];
                }
            } elseif ($request->get('input') == 'addRelated') {
                $this->addRelatedProduct($request);
                return 'ok';
            }
        }
    }

    public function index ()
    {
        $cartProducts = session('cartProducts');

        if (empty($cartProducts)) return view('empty-cart');

        $products = [];
        $index = 0;
        $productsIds = [];

        foreach ($cartProducts as $key => $cartProduct) {
            if ($key === 'total') {
                continue;
            }
            $products[$index] = $this->product->find($key);
            
            $products[$index]->qty = $cartProduct['productQty'];
            $productsIds[] = $products[$index]->id;
            $index++;
        }
        return view('cart', ['products' => $products]);
    }

    public function addToCart (Request $request)
    {
        $request->validate(
            [
                'productId' => 'required|integer|min:1|max:99999',
                'productQty' => 'required|integer|min:1|max:99'
            ],
            [
                'productQty.required' => 'The Quantity field can not be blank.',
                'productQty.integer' => 'Quantity must be integer.',
                'productQty.min' => 'Minimum of Quantity is 1 psc.',
                'productQty.max' => 'Maximum of Quantity is 99 psc.'
            ]);

        $productId = $request->get('productId');
        $qty = $request->get('productQty');

        if ($request->get('updateQty')) {
            $this->cartService->updateQty($productId, $qty);
        } else {
            $this->cartService->addToCart($productId, $qty);
        }

        if ($request->ajax()) {
            return ['items' => (count($request->session()->get('cartProducts')) - 2), 'total' => $request->session()->get('cartProducts.total')];
        }

        return redirect('cart');
    }
}
