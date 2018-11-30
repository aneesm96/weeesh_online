@extends('layouts.app')

@section('content')

<div class="container">
    <br />
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif



    <div class="row">
        <div class="col-md-12 text-center">
            <div class="btn btn-group cen">
                <a href="wlists/create" class="btn btn-primary">
                    <i class="fa fa-plus-square"></i> @lang("New List")
                </a>


            </div>
        </div>
    </div>


    <table class="table table-striped responsive">

        @foreach($wlists as $wlistKey => $wlistValue)
            <tr>

                <td>
                    <a href="{{action('WListController@show', $wlistValue->id_list)}}">{{ $wlistValue->name }}</a>
                </td>
                <td>{{  $wlistValue->list_privacy() }}</td>


                <td>




                                <form action="{{action('WListController@destroy', $wlistValue->id_list)}}"
                                      method="post" class="delete">
                                    <div class="btn btn-group">
                                    <a href="{{ URL::route('wlists.list_rows.create', $wlistValue->id_list) }}"
                                       class='btn btn-primary' title="@lang("Inserisci un nuovo oggetto")">
                                        <i class="fa fa-plus-square"></i>
                                    </a>


                                    <a href="{{action('WListController@edit', $wlistValue->id_list)}}"
                                       class="btn btn-warning" title="@lang("Modifica la lista")">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    @if( count( $wlistValue->list_rows) == 0)
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="btn btn-danger" type="submit" title="@lang("Cancella la lista")">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @endif
                                    </div>
                                </form>




            </tr>
        @endforeach

    </table>
</div>

@endsection