@extends('layouts.app')

@section('content')

<div class="container">

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif

<br/>
    <table class="table table-striped responsive">


        @foreach($friendships as $friendshipKey => $friendshipValue)
            <tr>
                <td>
                    <a href="{{action('UserProfileController@show', $friendshipValue->id_friend)}}">
                        {{$friendshipValue->name}}
                        {{$friendshipValue->surname}}
                    </a>
                </td>
                <td>
                    {{date('d/m/Y', strtotime($friendshipValue->date_from)) }}
                </td>
            </tr>
        @endforeach

    </table>
</div>
@endsection