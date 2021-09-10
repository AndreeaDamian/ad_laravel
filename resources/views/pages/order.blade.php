@extends('layouts.public')

@section('content')
    @include('header')
    <section>
        <div>
            <h3>{{ trans('strings.customerDetails') }}</h3>
            <table style="width: 50%">
                <tr>
                    <td style="width: 25%;font-weight: bold;">{{ trans('strings.name') }}</td>
                    <td><?= $order['name'] ?></td>
                </tr>
                <tr>
                    <td style="width: 25%;font-weight: bold;">{{ trans('strings.contactDetails') }}</td>
                    <td><?= $order['contact_details'] ?></td>
                </tr>
                <tr>
                    <td style="width: 25%;font-weight: bold;">{{ trans('strings.comment') }}</td>
                    <td><?= $order['comment'] ?></td>
                </tr>
            </table>
        </div>
    </section>
    <br>
    <section>
        <div>
            <h3>{{ trans('strings.purchasedProducts') }}</h3>
            <table>
                <tr>
                    <th>{{ trans('strings.nr') }}</th>
                    <th>{{ trans('strings.title') }}</th>
                    <th>{{ trans('strings.image') }}</th>
                    <th>{{ trans('strings.description') }}</th>
                    <th>{{ trans('strings.price') }}</th>
                </tr>
                @foreach ($order->products as $key => $product)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product->title }}</td>
                    <td><img style="height: 100px;display: flex;" src="{{ $product->image_path ? asset( $product->image_path) : asset('images/placeholder.png') }}"></td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    </section>

@stop