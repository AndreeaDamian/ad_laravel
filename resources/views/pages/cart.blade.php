@extends('layouts.public')

@section('title') - {{ trans('strings.cart') }} @stop

@section('content')
    @include('header')
    <section>
        <table>
            <tr>
                <th>{{ trans('strings.title') }}</th>
                <th>{{ trans('strings.image') }}</th>
                <th>{{ trans('strings.description') }}</th>
                <th>{{ trans('strings.price') }}</th>
                <th>{{ trans('strings.actions') }}</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td><img src="{{ $product->image_path ? asset($product->image_path) : asset('images/placeholder.png') }}"></td>

                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit">{{ trans('strings.remove') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
    <br>
    @if($products->count())
        <section>
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (session('message'))
                <p style="color: green">{{ session('message') }}</p>
            @endif
            <form class="checkout-form" action="{{ route('checkout') }}" method="POST">
                @csrf
                <div>
                    <label>{{ trans('strings.name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
                <div>
                    <label>{{ trans('strings.contactDetails') }}</label>
                    <textarea name="contact_details">{{ old('contact_details') }}</textarea>
                </div>
                <div>
                    <label>{{ trans('strings.comment') }}</label>
                    <textarea name="comment">{{ old('comment') }}</textarea>
                </div>
                <button class="btn-send" type="submit">Submit</button>
            </form>
        </section>
    @endif
@stop