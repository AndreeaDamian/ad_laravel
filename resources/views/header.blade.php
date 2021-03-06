<div>
    <ul class="menu">
        <li><a href="{{ route('home') }}">{{ trans('strings.home') }}</a></li>
        <li><a href="{{ route('cart') }}">{{ trans('strings.cart') }}</a></li>
        @if(Auth()->user())
            <li><a href="{{ route('products.index') }}">{{ trans('strings.products') }}</a></li>
            <li><a href="{{ route('orders.index') }}">{{ trans('strings.orders') }}</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">{{ trans('strings.logout') }}</button>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}">{{ trans('strings.login') }}</a></li>
        @endif
    </ul>
</div>