<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 30/12/2017
 * Time: 13:24
 */

namespace Weeesh\Http\Controllers;


use PharIo\Manifest\Email;
use Weeesh\FsRequest;
use Illuminate\Http\Request;


use Auth;
use Illuminate\Support\Facades\DB;
use Weeesh\Mail\MailMessage;
use Weeesh\Notifications\FSRequestAccepted;
use Weeesh\Notifications\FSRequestDenied;
use Weeesh\Notifications\NewFSRequest;
use Weeesh\User;
use Weeesh\UserProfile;


class FsRequestController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //
        $fs_request = $this->validate(request(), [
            'id_user_profile_by' => 'required|numeric',
            'id_user_profile_to' => 'required|numeric',
        ]);

        $newFSR = FsRequest::create($fs_request);

        if ($newFSR) {

            //se la richiesta è stata inserita, invio una notifica
            $user_to = $newFSR->user_profile_to->user;
            $user_to->notify(new NewFSRequest($newFSR));

            return back()->with('success', __('Request has been send'));
        }

        return back()->with('error', __('Request has not been send'));

    }

    /*
    * user: Francesco
    * date: 30/12/2017
    * time: 10:30
    *
    * check if 2 user_profiles are friends
    *
    * Return [{user_count:valore}]
    * per utilizzare il dato si può fare così
    *
    */
    public static function inWaiting($id_user_profile_a, $id_user_profile_b){

        $id_fs_request = DB::table('fs_request')
            ->select(DB::raw('count(*) as user_count'))
            ->where('id_user_profile_by',"=",$id_user_profile_a, "and")
            ->where('id_user_profile_to', "=",$id_user_profile_b, "and")
            ->where('id_user_profile_by',"=",$id_user_profile_b,"or")
            ->where('id_user_profile_to',"=",$id_user_profile_a)
            ->get("user_count");


        return $id_fs_request[0]->user_count;

    }


    /**
     *
     * @deprecated
     *
     * @param $mail message to send
     */
    public function mail($mail)
    {
        $email_controller = new EmailController();
        $email_controller->send($mail);

    }



    /*
     * @author: Francesco
     * @date: 30/12/17
     * @time: 14:35
     *
     * restituisce le informazioni di una richiesta di amicizia, a partire da due id_user_profile
     *
     */

    public static function get($id_user_profile_a, $id_user_profile_b){

        $fsr = DB::table('fs_request')
            ->where('id_user_profile_by',"=",$id_user_profile_a, "and")
            ->where('id_user_profile_to', "=",$id_user_profile_b, "and")
            ->where('id_user_profile_by',"=",$id_user_profile_b,"or")
            ->where('id_user_profile_to',"=",$id_user_profile_a)
            ->select('id_fs_request',
                            'id_user_profile_by',
                            'id_user_profile_to',
                            'id_fs_request_state',
                            'date_request')
            ->get();

        return $fsr;

    }

    /*
     * user: Francesco
     * date: 15/01/2018
     * time: 23:30
     *
     * restituisce elenco fsr che sono nello stato indicato e sono rivolte all'utente b
     *
     *
     */
    public static function getFSRequests($id_user_profile_b, $state){



        $fsrs = FsRequest::whereHas('fs_request_state', function($q) use ($state)
        {
            $q->where('id_fs_request_state', $state);
        })->where('id_user_profile_to', $id_user_profile_b)->get();

        //dd($fsrs);
        return $fsrs;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_list
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_fs_request)
    {
        //TODO: migliorare il recupero di id_user_profile
        //recupero l'id_user_profile attualmente loggato
        $id_up  = (Auth::user()->user_profiles)[0]['id_user_profile'];

        $fsr = FsRequest::find($id_fs_request);
        $old_state = $fsr->id_fs_request_state;

        $this->validate(request(), [

            'id_fs_request_state' => 'required|numeric',
        ]);

        $new_state = $request->get('id_fs_request_state');
        $fsr->id_fs_request_state = $new_state;

        $fsr->save();

        //creo il messaggio da mandare via mail
        if ($fsr) {

            $up_by = $fsr->user_profile_by;

            $message= "Request has been send";

            if($old_state==0){//richiesta di amicizia
                //dd("id_by:" . $up_by->id_user_profile);

                if($new_state==1){//accettata

                    $user_by = $fsr->user_profile_by->user;
                    $user_by->notify(new FSRequestAccepted($fsr));


                }
                elseif($new_state==2 && $up_by->id_user_profile != $id_up){//rifiutata dall'amico


                    $user_by = $fsr->user_profile_by->user;
                    $user_by->notify(new FSRequestDenied($fsr));



                }
                elseif($new_state==2 && $up_by->id_user_profile == $id_up){//annullata dal mittente
                    //$mail->subject( __("Friend Request Not Accepted on Weeesh.com !"));
                    //$mail->view         = "email.friendship.request-not-accepted";
                    //dd("1 > old_state: $old_state ; new state: $new_state ");
                    //non mando la mail
                    //annullo la riga di fs_request
                    //TODO: inserire nel log, oppure gestire meglio con uno storico

                    $fsr->delete();
                    $message= "The user will not receive notification!";



                }
            }

            return back()->with('success', __($message));
        }

        return back()->with('success', __('Request has been send'));

    }


}