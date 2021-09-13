<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Single Page App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="menu">
        <a href="#index">Home</a>
        <a href="#cart">Cart</a>
    </div>
    <div class="page index">
        <table class="list"></table>
    </div>
    <div class="page cart">
        <table class="list"></table>
        <br>
        <div class="error" style="display: none;">
        </div>
        <form id="checkout-form" class="checkout-form" style="height: auto">
            <div>
                <label>{{ trans('strings.name') }}</label>
                <input type="text" class="checkout-name" name="name" value="">
            </div>
            <div>
                <label>{{ trans('strings.contactDetails') }}</label>
                <textarea class="checkout-details"  name="contact_details"></textarea>
            </div>
            <div>
                <label>{{ trans('strings.comment') }}</label>
                <textarea class="checkout-comment"  name="comment"></textarea>
            </div>
            <button class="btn-send" type="submit">{{ trans('strings.checkout') }}</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/spa.js') }}"></script>
</body>
</html>