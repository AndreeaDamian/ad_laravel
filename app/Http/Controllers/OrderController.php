<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::orderBy('id', 'DESC')->get();

        if ($request->ajax()) {
            foreach ($orders as $order) {
                $order['total'] = $order->products->sum('price');
            }
            return response()->json($orders, 200);
        }
        return view('pages.orders', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        if ($request->ajax()) {
            $order['products'] = $order->products;
            return response()->json($order, 200);
        }
        return view('pages.order', compact('order'));
    }
}
