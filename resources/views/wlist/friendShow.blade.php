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



            <div class="row">
                <div class="col-xs-12 nomelista">{{ $wlist->name }}</div>
            </div>
            <div class="row">
                <div class="col-xs-12">di
                    <a href="{{ action('UserProfileController@show', [$userProfile->id_user_profile])}}">
                        {{ $userProfile->name . " " . $userProfile->surname}}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 ">@lang("Valide to"): {{ date('d/m/Y', strtotime($wlist->date_valide_to)) }}</div>

            </div>


    <h2>@lang("Objects")</h2>

    @if($wlist->list_rows->count() == 0)

        <p>
            @lang("Not yet object for this list.")
        </p>

    @else

        <div class="table-responsive">
            <table class="table table-striped responsive">
                @foreach ($wlist->list_rows as $list_row)
                    <tr>
                        <?php
                        /*
                         * date: 30/12/17
                         * time: 11:36
                         * user: Francesco
                         *
                         * recupero l'id_user_profile dell'utente loggato, visto che al momento ogni utente
                         * ha un solo user_profile
                         *
                         * @TODO: migliorare quest'aspetto, l'utente deve poter scegliere il proprio profilo
                         */
                        $id_up  = (\Auth::user()->user_profiles)[0]['id_user_profile']
                        ?>
                            @if($list_row->isBooked())

                                    <td>
                                        <div class="status giallo"></div>
                                        <div style="float: left">{{$list_row->object}}</div>
                                    </td>
                                <?php
                                /*
                                 * date: 20/01/2018
                                 * time: 19:40
                                 * user: Francesco
                                 *
                                 * recupero la riga di booking relativa all'user profile
                                 *
                                 */
                                $booking = \Weeesh\Http\Controllers\BookingController::getBooking($list_row->id_list_row)
                                ?>
                                    <td>
                                        @if($booking->id_user_profile = $id_up)
                                                <form action="{{action('BookingController@destroy',$booking->id_booking)}}"
                                                      method="post">
                                                    {{csrf_field()}}
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button class="btn btn-primary" type="submit">@lang("Undo")</button>
                                                </form>
                                        @else
                                            @lang("Already booked")
                                        @endif
                                    </td>

                            @else

                                    <td >
                                        <div class="status verde"></div>
                                        <div style="float: left">{{$list_row->object}}</div>
                                    </td>
                                    <td >
                                        <form action="{{action('BookingController@store')}}" method="post">
                                            {{csrf_field()}}
                                            <button class="btn btn-primary" type="submit">@lang("Book now")</button>
                                            <input type="hidden" name="id_state_booking" value="1"/>
                                            <input type="hidden" name="id_list_row" value="{{$list_row->id_list_row}}"/>
                                            <input type="hidden" name="id_user_profile" value="{{$id_up}}"/>
                                        </form>
                                    </td>



                            @endif
                                </tr>
                @endforeach
            </table>
        </div>
        @endif
    </div>
@endsection