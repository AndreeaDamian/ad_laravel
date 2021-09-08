@extends('layout')

@section('content')
    @include('header')
    <h2>Products</h2>
    <section class="box">
        @forelse ($products as $product)
            <div class="product-box">
                <h1>{{ $product->title }}</h1>
                <img src="{{ asset('images/placeholder.png') }}">
                <div>
                    <p>{{ $product->description }}</p>
                </div>
                <span>{{ $product->price }} €</span>
                <form action="{{ route('add.cart') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit">Add to cart</button>
                </form>
            </div>
        @empty
            <h3>There are no products!</h3>
        @endforelse
    </section>
@stop