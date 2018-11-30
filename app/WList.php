<?php

namespace Weeesh;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;

class WList extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wlist';
    protected $primaryKey='id_list';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','date_valide_from', 'date_valide_to','id_user_profile_creator','id_list_privacy','date_vaide_to', 'date_valide_from'];


    /*
     *
     * @author: Francesco
     * @date: 10/12/2017
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

    /*
     * https://laracasts.com/discuss/channels/laravel/how-to-obtain-data-from-another-table-using-foreign-key-in-view?page=1
     *
     */
    public function list_privacy() {
        $this->belongsTo('Weeesh\ListPrivacy');

        /*
         * da modificare con list_privacy_language
         */
        $privacy_name = DB::table('list_privacy')
            ->select('name')
            ->where('id_list_privacy',$this->id_list_privacy)
            ->value('name');

        return $privacy_name;

    }//list_privacy


    /**
     * Each list can be associated with one or more row list.
     *
     */
    public function list_rows()
    {
        return $this->hasMany('Weeesh\ListRow', 'id_list', 'id_list');
    }

    /**
     * Every list belongs to a UserProfile
     *
     */
    public function user_profile()
    {
        return $this->belongsTo('Weeesh\UserProfile' , 'id_user_profile_creator', 'id_user_profile');
    }


}
