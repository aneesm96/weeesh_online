@extends('layouts.app')

@section('content')

<div class="container">



    <br />
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif


    <table class="table table-striped responsive">

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
        @foreach($user_profiles as $user_profile)
            <tr>
            @if($user_profile->id_user_profile != $id_up )
                    <td>
                        <a href="{{ url('/user_profiles').'/'.$user_profile->id_user_profile }}">
                        {{$user_profile->name}} {{$user_profile->surname}}

                    </td>

                        @if  (  $user_profile->isFriend($id_up) )
                        <td colspan="2">

                            <a href="{{ url('/user_profiles').'/'.$user_profile->id_user_profile }}">
                                @lang("View profile")
                            </a>
                        </td>

                        @elseif ( $user_profile->fsRequestSend($id_up))
                            <?php //se l'ho ricevuta posso accettare/rifiutare, altrimenti cancellare/waiting ?>

                            <?php $fsr = \Weeesh\Http\Controllers\FsRequestController::get($id_up, $user_profile->id_user_profile); ?>

                            @if($fsr[0]->id_user_profile_by == $id_up and $fsr[0]->id_fs_request_state < 2 )
                                <td colspan="2">
                                    <form action="{{action('FsRequestController@update',$fsr[0]->id_fs_request)}}" method="post">
                                        {{csrf_field()}}
                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-primary" type="submit">@lang("Undo")</button>
                                        <input type="hidden" name="id_fs_request_state" value="2"/>
                                    </form>
                                </td>

                            @elseif($fsr[0]->id_fs_request_state < 2)
                                <td>
                                    <form action="{{action('FsRequestController@update',$fsr[0]->id_fs_request)}}" method="post">
                                        {{csrf_field()}}
                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-primary" type="submit">@lang("Accept")</button>
                                        <input type="hidden" name="id_fs_request_state" value="1"/>

                                    </form>
                                </td>
                                <td>
                                    <form action="{{action('FsRequestController@update',$fsr[0]->id_fs_request)}}" method="post">
                                        {{csrf_field()}}
                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-primary" type="submit">@lang("Deny")</button>
                                        <input type="hidden" name="id_fs_request_state" value="2">

                                    </form>
                                </td>
                            @elseif($fsr[0]->id_fs_request_state = 2 && $fsr[0]->id_user_profile_by != $id_up)
                                    <td colspan="2">
                                    @lang("Not accepted!")
                                    </td>
                            @endif

                    @else
                            <td colspan="2">
                            <form action="{{action('FsRequestController@store')}}" method="post">
                                {{csrf_field()}}

                                <button class="btn btn-primary" type="submit">@lang("Send Request")</button>
                                <input type="hidden" name="id_user_profile_by" value="{{$id_up}}"/>
                                <input type="hidden" name="id_user_profile_to" value="{{$user_profile->id_user_profile}}"/>
                            </form>
                            </td>
                        @endif
            @endif
            </tr>
        @endforeach
       
    </table>
</div>
@endsection