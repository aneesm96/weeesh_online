<?php

namespace Weeesh;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;
use Weeesh\Http\Controllers\BookingController;


class ListRow extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'list_row';
    protected $primaryKey='id_list_row';

    protected $fillable = ['id_list','object','link_web','updated_at','created_at','id_user_profile_creator','id_list_privacy'];


    /**
     * Every listrow belongs to a Wlist
     *
     */
    public function Wlist()
    {
        return $this->belongsTo('Weeesh\Wlist' , 'id_list', 'id_list');
    }


    /*
     * User: Francesco
     * Date: 30/12/2017
     * Time: 20:35
     *
     * Check if this list_row is already booked
     *
     */
    public function isBooked(){
        $result =  BookingController::isBooked($this->id_list_row);
        return $result;
    }


    /*
     *
     * @author: Francesco
     * @date: 17/12/2017
     */
    public static function create(array $attributes = [])
    {

        /**
         * devo cercare id_user_profile
         * in futuro potrà essere scelto dall'utente che decide di creare una nuova lista
         * con il proprio profilo, oppure con un altro profilo (esempio aziendale)
         * si potrebbe inserire un drop-down menu nel form e questa funzione diventa obsoleta
         */
        $id_user = Auth::user()->id;
        $id_user_profile_creator = DB::table('user_profile')
            ->select('id_user_profile')
            ->where('id_user',$id_user)
            ->value('id_user_profile');

        $attributes['id_user_profile_creator'] =  $id_user_profile_creator;
        $model = static::query()->create($attributes);

        return $model;
    }//create






}
