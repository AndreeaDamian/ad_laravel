@extends('layouts.public')

@section('title') - {{ trans('strings.orders') }} @stop

@section('content')
    @include('header')
    <section>
        <table>
            <tr>
                <th>{{ trans('strings.nr') }}</th>
                <th>{{ trans('strings.date') }}</th>
                <th>{{ trans('strings.contactDetails') }}</th>
                <th>{{ trans('strings.total') }}</th>
                <th>{{ trans('strings.actions') }}</th>
            </tr>
            @foreach ($orders as $key => $order)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <table>
                            <tr>
                                <td>{{ trans('strings.name') }}</td>
                                <td>{{ $order->name }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('strings.contactDetails') }}</td>
                                <td>{{ $order->contact_details }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('strings.comment') }}</td>
                                <td>{{ $order->comment }}</td>
                            </tr>
                        </table>
                    <td>{{ $order->products->sum('price') }}</td>
                    <td><a href="{{ route('orders.show', $order->id) }}">{{ trans('strings.details') }}</a></td>
                </tr>
            @endforeach
        </table>
    </section>
@stop