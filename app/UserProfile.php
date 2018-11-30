<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 28/12/2017
 * Time: 20:47
 */

namespace Weeesh;

use Illuminate\Database\Eloquent\Model;
use Weeesh\Friendship;
use Weeesh\Http\Controllers\FriendshipController;
use Weeesh\Http\Controllers\FsRequestController;

class UserProfile extends Model
{


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_profile';
    protected $primaryKey='id_user_profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name',
                            'surname',
                            'date_of_birth',
                            'photo',
                            'address',
                            'id_city',
                            'id_language'];


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

    /*
     * User: Francesco
     * Date: 30/12/2017
     * Time: 14:17
     *
     * Check if this instance of user_profile is a friend of $id_user_profile
     *
     */
    public function fsRequestSend($id_user_profile){
        $result =  FsRequestController::inWaiting($this->id_user_profile, $id_user_profile);
        return $result;
    }




    /**
     * Each user_profile can be associated with one or more list.
     *
     */
    public function wlists()
    {
        return $this->hasMany('Weeesh\WList', 'id_user_profile_creator', 'id_user_profile');
    }

    /**
     * Every user_profile belongs to a User
     */
    public function user()
    {
        return $this->belongsTo('Weeesh\User' , 'id_user', 'id');
    }



}