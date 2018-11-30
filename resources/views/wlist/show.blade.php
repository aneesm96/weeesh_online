@extends('layouts.app')

@section('content')

    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br />
        @endif


    <a href="{{ URL::route('wlists.index') }}">@lang("My Lists")</a> ><h1> {{ $wlist->name }}</h1>

    <p>
        @lang("Created on"): {{ date('F d, Y', strtotime($wlist->created_at)) }} <br />
        @lang("Last modified"): {{ date('F d, Y', strtotime($wlist->updated_at)) }}<br />

    </p>

    <h2>@lang("Objects")</h2>

    <p>
        <a href="{{ URL::route('wlists.list_rows.create', $wlist->id_list) }}" class='btn btn-primary'>@lang("Add an object")</a>
    </p>

    @if($wlist->list_rows->count() == 0)

        <p>
            @lang("Not yet object for this list.")
            <a href="{{ URL::route('wlists.list_rows.create', $wlist->id_list) }}">@lang("Add an object")</a>.
        </p>

    @else

        <div class="table-responsive">
            <table class="table table-striped responsive">
                @foreach ($wlist->list_rows as $list_row)
                    <tr>

                        <td>
                            @if($list_row->isBooked())
                                    <?php //TODO: verificare x gli oggetti gia prenotati le azioni da intraprendere?>
                                    {{ $list_row->object }}

                            @else
                                <a href="{{ URL::route('wlists.list_rows.edit',  [$wlist->id_list, $list_row->id_list_row]) }}">
                                    {{ $list_row->object }}
                                </a>


                            @endif
                        </td>
                        <!--
                        <td>
                            <a href="{{ URL::route('wlists.list_rows.edit',  [$wlist->id_list, $list_row->id_list_row]) }}">@lang("Edit")</a>
                        </td>
                        -->
                        <td>
                            <?php
                                /**
                                 *
                                 * TODO: se l'oggetto è stato prenotato, non posso cancellare
                                 * x cancellare: mando una mail a chi ha prenotato,chiedendo se faccio ancora
                                 * in tempo a cancellare
                                 * x modificare: mando una mail a chi ha prenotato,chiedendo se faccio ancora
                                 * in tempo a modificare
                                 *
                                 * resto in attesa di risposta
                                 */
                               ?>
                            @if($list_row->isBooked())

                                @lang("Already Booked")

                            @else
                            <form action="{{ URL::route('wlists.list_rows.destroy', [$wlist->id_list, $list_row->id_list_row]) }}" method="post">
                                {{csrf_field()}}
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="btn btn-danger" type="submit">@lang("Delete")</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        @endif
    </div>
@endsection