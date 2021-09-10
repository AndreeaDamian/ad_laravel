@extends('layouts.public')

@section('title') - {{ trans('strings.cart') }} @stop

@section('content')
    @include('header')
    <section>
        <div style="margin-bottom: 20px; margin-left: 10px;">
            <a href="{{ route('products.create') }}" style="background-color: darkgray; padding: 10px; text-decoration: none">{{ trans('strings.addProduct') }}</a>
        </div>
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
                        <a href="{{ route('products.edit', $product->id) }}">{{ trans('strings.edit') }}</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit">{{ trans('strings.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
@stop