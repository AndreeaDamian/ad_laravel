<html>
<head>
    <title>{{ trans('strings.shopOrder') }}</title>
</head>
    <body>
        <p>{{ trans('strings.orderDate') }} : {{ $data['date'] }}</p>
        <table style="border: solid 2px black; border-collapse: collapse; display: table;  width: 100%;">
            <tr style="border: solid 1px black; padding: 10px; text-align: left;">
                <th>{{ trans('strings.name') }}</th>
                <th>{{ trans('strings.contactDetails') }}</th>
                <th>{{ trans('strings.comment') }}</th>
            </tr>
            <tr style="border: solid 1px black; padding: 10px; text-align: left;">
                <td>{{ $data['name']  }}</td>
                <td>{{ $data['contact_details']  }}</td>
                <td>{{ $data['comment']  }}</td>
            </tr>
        </table>
        <br>
        <table style="border: solid 2px black; border-collapse: collapse; display: table;  width: 100%;">
            <tr style="border: solid 1px black; padding: 10px; text-align: left;">
                <th>{{ trans('strings.title') }}</th>
                <th>{{ trans('strings.image') }}</th>
                <th>{{ trans('strings.description') }}</th>
                <th>{{ trans('strings.price') }}</th>
            </tr>
            @foreach ($data['products'] as $product)
                <tr style="border: solid 1px black; padding: 10px; text-align: left;">
                    <td>{{ $product->title  }}</td>
                    <td><img src="{{ asset('../assets/images/placeholder.png') }}"></td>
                    <td>{{ $product->description  }}</td>
                    <td>{{ $product->price  }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>