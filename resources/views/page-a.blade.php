@extends('layout.app')

@section('content')
    <div class="a_page">
        <h3>A-Page</h3>

        <div>
            <a href="{{ route('new-link', ['hash' => $link->hash]) }}" type="button" class="btn btn-primary">Generate New Link</a>
            <a href="{{ route('deactivate-link', ['hash' => $link->hash]) }}" type="button" class="btn btn-danger">Deactivate</a>
        </div>

        <div class="my-3">
            <input type="hidden" name="link" value="{{ $link->hash }}">
            <button type="button" class="btn btn-success" id="imfeelinglucky">I'm feeling lucky</button>
            <button type="button" class="btn btn-secondary" id="history">History</button>
        </div>

        <table class="table visually-hidden">
            <thead>
            <tr>
                <th scope="col">Value</th>
                <th scope="col">Result</th>
                <th scope="col">Prize</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
