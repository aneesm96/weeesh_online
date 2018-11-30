<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 26/12/2017
 * Time: 22:32
 */

namespace Weeesh;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;


/*
 * @TODO: copiata da Wlist - Verificare e modificare 26/12/17
 */

class Friendship extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'friendship';
    protected $primaryKey='id_friendship';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id_friendship',
                            'id_user_profile_by',
                            'id_user_profile_to',
                            'date_from',
                            'date_to',
                            'notes'];

    protected $dates =  ['date_from','date_to'];


    /*
     *
     * @author: Francesco
     * @date: 26/12/2017
     *
     * @TODO: implementare
     */
    public static function create(array $attributes = [])
    {
        /**
         * devo cercare id_user_profile
         * in futuro potrà essere scelto dall'utente che decide di creare una nuova lista
         * con il proprio profilo, oppure con un altro profilo (esempio aziendale)
         * si potrebbe inserire un drop-down menu nel form e questa funzione diventa obsoleta

        $id_user = Auth::user()->id;
        $id_user_profile_creator = DB::table('user_profile')
            ->select('id_user_profile')
            ->where('id_user',$id_user)
            ->value('id_user_profile');

        $attributes['id_user_profile_creator'] =  $id_user_profile_creator;
        $model = static::query()->create($attributes);

        return $model;
        */
    }//create


    /**
     * Each list can be associated with one or more row list.
     * @TODO: verificare il collegamento N:N - belongsTo - vedi Wlist.php
     *
     */


}