@extends('layouts.app')

@section('content')

<div class="container">
    <br />
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif


    <a href="wlists/create">@lang("New Friend")</a>

    <br/>
    <br/>

    <table class="table table-striped responsive">
        <thead>
        <tr>

            <th>@lang("Name")</th>
            <th>@lang("From")</th>
            <th colspan="3">@lang("Action")</th>
        </tr>
        </thead>
        <tbody>
        @foreach($wlists as $wlistKey => $wlistValue)
            <tr>

                <td>
                    <a href="{{action('UserController@show@show', $wlistValue->id_list)}}">{{ $wlistValue->name }}</a>
                </td>
                <td>{{  $wlistValue->list_privacy() }}</td>


                <td>
                    <a href="{{ URL::route('wlists.list_rows.create', $wlistValue->id_list) }}" class='btn btn-primary'>@lang("Add an object")</a>
                </td>

                <td>
                    <a href="{{action('WListController@edit', $wlistValue->id_list)}}" class="btn btn-warning">@lang("Edit")</a>
                </td>

                @if( count( $wlistValue->list_rows) == 0)
                    <td>
                        <form action="{{action('WListController@destroy', $wlistValue->id_list)}}" method="post">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-danger" type="submit">@lang("Delete")</button>
                        </form>
                    </td>
                @else
                    <td>
                        @lang("Not Yet!")
                    </td>

                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection