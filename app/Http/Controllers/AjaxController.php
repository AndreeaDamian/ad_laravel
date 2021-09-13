<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
    public function index()
    {
        $cartIds = Session::get('cart');
        $products = Product::when($cartIds != null, function ($query) use($cartIds) {
            $query->whereNotIn('id', $cartIds);
        })
            ->get();

        return response()->json($products, 200);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
           'product_id' => ['required', 'exists:products,id']
       ]);
        $productId = $request->input('product_id');

        if (!$request->session()->has('cart')) {
            Session::push('cart', $productId);
        } else {
            if (!in_array($productId, Session::get('cart'))) {
                Session::push('cart', $productId);
            }
        }

        $cartIds = Session::get('cart');
        $products = Product::when($cartIds != null, function ($query) use($cartIds) {
            $query->whereNotIn('id', $cartIds);
        })
            ->get();

        return response()->json($products, 200);
    }

    public function cart()
    {
        $cartIds = Session::get('cart') != null ? Session::get('cart') : [];
        $products = Product::whereIn('id', $cartIds)->get();

        return response()->json($products, 200);
    }

    public function removeItem(Request $request)
    {
        $key = array_search($request->input('product_id'), Session::get('cart'));
        Session::forget('cart.'.$key);
        $cartIds = Session::get('cart') != null ? Session::get('cart') : [];
        $products = Product::whereIn('id', $cartIds)->get();

        return response()->json($products, 200);
    }

    public function checkout(Request $request)
    {
        $request->validate([
           'name' => ['required'],
           'contact_details' => ['required']
       ]);

        if (!$request->session()->has('cart')) {
            return response()->json(['message' => trans('cartMustHave')], 422);
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

            $order = Order::create($request->input());
            foreach ($products as $product) {
                OrderProduct::create([
                     'order_id' => $order->id,
                     'product_id' => $product->id,
                 ]);
            }

            Mail::to($to)->send(new Checkout($data));
            Session::forget('cart');

            return response()->json([], 201);
        }
    }

}
