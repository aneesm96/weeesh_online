<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 30/12/2017
 * Time: 12:16
 *
 *
 * Friend Ship Request from "user profile" to "another user profile"
 */

namespace Weeesh;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;

class FsRequest extends Model
{



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fs_request';
    protected $primaryKey='id_fs_request';

    /*
     * @TODO: rimuovere ed inserire le due colonne nella tabella
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_user_profile_by',
                            'id_user_profile_to',
                            'date_request',
                            'id_fs_request_state',
                            'date_change_state',
                            'id_user_profile_changed_by'];

    /*
      *
      * @author: Francesco
      * @date: 30/12/2017
      *
      */
    public static function create(array $attributes = [])
    {
        /**
         * @TODO: devo cercare id_user_profile
         * in futuro potrà essere scelto dall'utente che decide di creare una nuova lista
         * con il proprio profilo, oppure con un altro profilo (esempio aziendale)
         * si potrebbe inserire un drop-down menu nel form e questa funzione diventa obsoleta
         */
        $id_user = Auth::user()->id;
        $id_user_profile_creator = DB::table('user_profile')
            ->select('id_user_profile')
            ->where('id_user',$id_user)
            ->value('id_user_profile');

        $attributes['id_user_profile_changed_by'] =  $id_user_profile_creator;

        $model = static::query()->create($attributes);

        return $model;
    }//create



    /**
     * Every Friend Request is made by UserProfile
     */
    public function user_profile_by()
    {
        return $this->belongsTo('Weeesh\UserProfile' , 'id_user_profile_by', 'id_user_profile');
    }

    /**
     * Every Friend Request is made to a UserProfile
     */
    public function user_profile_to()
    {
        return $this->belongsTo('Weeesh\UserProfile' , 'id_user_profile_to', 'id_user_profile');
    }

    /**
     * Every Friend Request has a current state
     */
    public function fs_request_state()
    {
        return $this->belongsTo('Weeesh\FsRequestState' , 'id_fs_request_state', 'id_fs_request_state');
    }


}