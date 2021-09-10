<div>
    <ul class="menu">
        <li><a href="{{ route('home') }}">{{ trans('strings.home') }}</a></li>
        <li><a href="{{ route('cart') }}">{{ trans('strings.cart') }}</a></li>
        @if(Auth()->user())
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