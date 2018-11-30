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

   <h3> {{ $userProfile->name . " " . $userProfile->surname }}</h3>

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
    @if($userProfile->isFriend($id_up))


            @if($userProfile->wlists->count() == 0)

                <p>
                    @lang("Not yet list")
                </p>

            @else

                <div class="table-responsive">
                    <table class="table table-striped responsive">
                        @foreach ($userProfile->wlists as $wlist)
                            <tr>

                                <td>
                                    <a href="{{ URL::route('user_profiles.wlists.friend_show', [$userProfile->id_user_profile, $wlist->id_list])}}">{{ $wlist->name }}</a>
                                </td>
                                <td>
                                   scadenza:
                                    {{ date('d/m/Y', strtotime($wlist->date_valide_to)) }}

                                </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif

    </div>
    @else

        @lang("You are not allowed")
        <br />
        @lang("add friend")

    @endif
@endsection