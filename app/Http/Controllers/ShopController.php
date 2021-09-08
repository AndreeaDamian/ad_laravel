<?php


namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShopController
{
    public function index()
    {
        $cartIds = Session::get('cart');
        $products = Product::when($cartIds != null, function ($query) use($cartIds) {
            $query->whereNotIn('id', $cartIds);
        })
            ->get();
        return view('pages.index', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id']
        ]);
        $productID = $request->input('product_id');

        if (!$request->session()->has('cart')) {
            Session::push('cart', $productID);
        } else {
            if (!in_array($productID, Session::get('cart'))) {
                Session::push('cart', $productID);
            }
        }

        return redirect()->back();
    }
}