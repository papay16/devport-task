@extends('layout.app')

@section('content')
    <div class="cabinet text-center w-100 m-auto">
        <h3>User Cabinet</h3>
        <p>Hello, {{ auth()->user()->username }}. <a href="{{ route('logout') }}">logout</a></p>

        @if($links->count())
            Here your links:
            <div class="list">
                <ul class="list-group">
                    @foreach($links as $link)
                        <li class="list-group-item @if($link->expired) disabled @endif">
                            @if($link->expired) <s> @endif
                            <a href="{{ route('apage', ['hash' => $link->hash]) }}">{{ $link->hash }}</a>
                            @if($link->expired) </s> @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
@endsection
