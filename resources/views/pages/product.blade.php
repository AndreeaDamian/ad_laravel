@extends('layouts.public')

@section('title') - {{ $product->name ?? trans('strings.addProduct') }} @stop

@section('content')
    @include('header')
    <section>
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form class="checkout-form" method="POST" action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" enctype="multipart/form-data">
            @csrf
            @if (isset($product))
                <input type="hidden" name="_method" value="PUT">
            @endif
            <div>
                <label>{{ trans('strings.title') }}</label>
                <input type="text" name="title" value="{{ $product->title ?? old('title') ?? '' }}">
            </div>
            <div>
                <label>{{ trans('strings.description') }}</label>
                <textarea rows="7" name="description">{{ $product->description ?? old('description') ?? '' }}</textarea>
            </div>
            <div>
                <label>{{ trans('strings.price') }}</label>
                <input type="text" name="price" value="{{ $product->price ?? old('price') ?? '' }}">
            </div>
            <div>
                @if (isset($product) && $product->image_path)
                    <img src="{{ asset($product->image_path) }}" alt="Product Image">
                @endif
                <input type="file" name="image" accept="image/*" id="fileToUpload">
            </div>
            <div>
                <button class="btn-send" type="submit"><?= isset($product) ? trans('strings.edit') : trans('strings.addProduct') ?></button>
            </div>
        </form>
    </section>
@stop