<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::all();
        if($request->ajax()) {
            return response()->json($products);
        }
        return view('pages.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => ['required'],
           'description' => ['nullable'],
           'price' => ['required'],
       ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = time().'.'.$file->extension();
            $file->move(public_path('uploads'), $image);
            $request['image_path'] = 'uploads/'.$image;
        }
        Product::create($request->input());
        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request['id'] = $product->id;
        $request->validate([
            'id' => ['exists:products,id'],
            'title' => ['required'],
            'description' => ['nullable'],
            'price' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg']
       ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = time().'.'.$file->extension();
            $file->move(public_path('uploads'), $image);
            $request['image_path'] = 'uploads/'.$image;
        }
        $product->update($request->input());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back();
    }
}
