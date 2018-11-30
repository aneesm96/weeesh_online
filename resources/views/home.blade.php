@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

            <div class="panel panel-default">


                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="btn btn-group cen">
                                    <a href="wlists/create" class="btn btn-primary">
                                        <i class="fa fa-plus-square"></i> @lang("New List")
                                    </a>
                                    

                                    <a href="{{ url('/wlists') }}" class="btn btn-success">
                                        <i class="fa fa-edit"></i> {{ __('My Lists') }}
                                    </a>

                                </div>
                            </div>
                        </div>
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
                     $id_up  = (\Auth::user()->user_profiles)[0]['id_user_profile'];
                     $state  = 0;
                     $fsr_s  = \Weeesh\Http\Controllers\FsRequestController::getFSRequests($id_up, $state);
                     ?>

                        @if(count($fsr_s)>0)

                            <br clear="all" />

                            @lang("Friendship Requests")
                            <br clear="all" />

                            <table class="table table-striped responsive" >
                                <thead>
                                <tr>
                                    <th> @lang("Name")</th>
                                    <th colspan="2">@lang("Action")</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($fsr_s as $fsr)
                                <tr>
                                    <td>
                                        {{$fsr->user_profile_by->name}}
                                        {{$fsr->user_profile_by->surname}}
                                    </td>
                                    <td>
                                        <form action="{{action('FsRequestController@update',$fsr->id_fs_request)}}" method="post">
                                            {{csrf_field()}}
                                            <input name="_method" type="hidden" value="PATCH">
                                            <button class="btn btn-primary" type="submit">@lang("Accept")</button>
                                            <input type="hidden" name="id_fs_request_state" value="1"/>

                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{action('FsRequestController@update',$fsr->id_fs_request)}}" method="post">
                                            {{csrf_field()}}
                                            <input name="_method" type="hidden" value="PATCH">
                                            <button class="btn btn-primary" type="submit">@lang("Deny")</button>
                                            <input type="hidden" name="id_fs_request_state" value="2">

                                        </form>
                                    </td>
                                 </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif


                        <!-- @TODO: mostrare elenco degli ultimi regali inseriti -->
                        <div class="panel-group">

                            <div class="panel panel-default feed">
                                <div class="panel-body feed-body">

                                    <div class="row">
                                        <div class="col-xs-12 nome">Sara Mollo</div>

                                    </div>
                                    <div class="row">
                                        <div class="nomelista col-xs-8">Compleanno 2018</div>
                                        <div class="col-xs-4 data">13/06/2018</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">Telefono</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">lavastoviglie</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">auto</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">scarpe</div>
                                    </div>
                                </div>
                            </div>


                            <div class="panel panel-default feed">
                                <div class="panel-body feed-body">

                                    <div class="row">
                                        <div class="col-xs-12 nome">Sara Mollo</div>

                                    </div>
                                    <div class="row">
                                        <div class="nomelista col-xs-8">Compleanno 2018</div>
                                        <div class="col-xs-4 data">13/06/2018</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">Telefono</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">lavastoviglie</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">auto</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-2 stato"><i class="fas fa-cart-arrow-down"></i></div>
                                        <div class="col-xs-10 oggetto">scarpe</div>
                                    </div>
                                </div>
                            </div>


                        </div>

                </div>
            </div>

    </div>
</div>
@endsection
