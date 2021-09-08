<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function cart()
    {
        $cartIds = Session::get('cart') != null ? Session::get('cart') : [];
        $products = Product::whereIn('id', $cartIds)->get();

        return view('pages.cart', compact('products'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'contact_details' => ['required']
        ]);

        if (!$request->session()->has('cart')) {
            return redirect()->back()->with('error', 'Cart must have items!');
        } else {
            $cartIds = Session::get('cart');
            $products = Product::whereIn('id', $cartIds)->get();
            $to = env('SHOP_MANAGER_MAIL');
            $date = date('Y-m-d H:i:s');
            $data = [
                'date' => $date,
                'name' => $request->input('name'),
                'contact_details' => $request->input('contact_details'),
                'comment' => $request->input('contact_details'),
                'products' => $products
            ];

            Mail::to($to)->send(new Checkout($data));
            Session::forget('cart');

            return redirect()->back()->with('message', 'Success!');
        }
    }
}