<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 30/12/2017
 * Time: 20:16
 */

namespace Weeesh;
use Illuminate\Database\Eloquent\Model;


class Booking extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'booking';
    protected $primaryKey='id_booking';

    /*
     * @TODO: rimuovere ed inserire le due colonne nella tabella
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id_booking',
                            'id_user_profile',
                            'id_list_row',
                            'date_booking',
                            'id_state_booking',
                            'notes'];

    /**
     * Every booking belongs to a list_row
     *
     */
    public function list_row()
    {
        return $this->belongsTo('Weeesh\ListRow' , 'id_list_row', 'id_list_row');
    }

    /**
     * Every booking belongs to a user_profile
     *
     */
    public function user_profile()
    {
        return $this->belongsTo('Weeesh\UserProfile' , 'id_user_profile', 'id_user_profile');
    }

    /**
     * Every booking belongs to a state_booking
     *
     */
    public function id_state_booking()
    {
        return $this->belongsTo('Weeesh\StateBooking' , 'id_state_booking', 'id_user_profile');
    }


    /*
 * User: Francesco
 * Date: 30/12/2017
 * Time: 09:00
 *
 * Check if this instance of user_profile is a friend of $id_user_profile
 *
 */
    public function isFriend($id_user_profile){
        $result =  FriendshipController::areFriends($this->id_user_profile, $id_user_profile);
        return $result;
    }


}