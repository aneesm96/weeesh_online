<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 30/12/2017
 * Time: 20:27
 */

namespace Weeesh\Http\Controllers;

use Illuminate\Http\Request;
use Weeesh\Booking;
use Weeesh\Notifications\BookingCancelled;
use Weeesh\Notifications\NewBooking;
use Weeesh\User;
use Weeesh\UserProfile;
use Weeesh\WList;
use Weeesh\ListRow;
use Auth;
use Illuminate\Support\Facades\DB;
use Weeesh\Mail\MailMessage;


class BookingController extends Controller
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
        $booking = $this->validate(request(), [
            'id_state_booking' => 'required|numeric',
            'id_user_profile' => 'required|numeric',
            'id_list_row' => 'required|numeric',
        ]);

        $newBooking = Booking::create($booking);


        if ($newBooking) {

            //se la richiesta è stata inserita, invio una notifica
            //devo recuperare l'utente a cui mandare la notifica
            //da booking recupero list row
            //da list row recupero list
            //da list recupero user_profile

            $id_up_to = WList::find( ListRow::find($newBooking->id_list_row)->id_list)->id_user_profile_creator;

            $user_to = User::find(UserProfile::find($id_up_to)->id_user);

            //dd($user_to->name);

            $user_to->notify(new NewBooking($newBooking));
            return back()->with('success', __('Object has been booked!'));

        }

        return back()->with('error', __('Request has not been send'));

    }


    /*
     * user: Francesco
     * date: 30/12/2017
     * time: 20:30
     *
     * check if a list row was already booked
     *
     *
     */
    public static function isBooked($id_list_row){

        $n_booking = DB::table('booking')
            ->select(DB::raw('count(*) as count'))
            ->where('id_list_row',"=",$id_list_row )
            ->get("count");
        return $n_booking[0]->count;
    }


    /*
     * user:Francesco
     * date: 20/01/2018
     * time: 19:30
     *
     * restituisce l'oggetto Booking, e quindi tutte le info collegate
     *
     *
     */
    public static function getBooking($id_list_row){

        if(BookingController::isBooked($id_list_row)){
            $booking = Booking::where('id_list_row', $id_list_row)->first();

            return $booking;

        }
        return null;
    }//getBooking


    /**
     *
     *
     *
     * @param $mail message to send
     */
    public function mail($mail)
    {
        $email_controller = new EmailController();
        $email_controller->send($mail);

    }


    /**
    * Delete the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id_booking
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, $id_booking){

        $booking =Booking::find($id_booking);

        if ($booking) {

            //se la richiesta è stata inserita, invio una notifica
            //devo recuperare l'utente a cui mandare la notifica
            //da booking recupero list row
            //da list row recupero list
            //da list recupero user_profile

            $id_up_to = WList::find( ListRow::find($booking->id_list_row)->id_list)->id_user_profile_creator;
            $user_to = User::find(UserProfile::find($id_up_to)->id_user);
            $user_to->notify(new BookingCancelled($booking));
            $booking->delete();
            return back()->with('success', __('Booking has been deleted!'));
        }

    }//destroy


}