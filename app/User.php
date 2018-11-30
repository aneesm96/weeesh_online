<?php


namespace Weeesh;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey='id';

    /**
     * @TODO: aggiungere Cognome, data di nascita in fase di registrazione
     * @TODO: inserire tabella per indirizzo di consegna (+ indirizzi...)
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * Determines if the user owns a particular list
     * @param  integer $listId
     * @return Boolean
     */
    public function owns($id_list)
    {
        $wlist = WList::find($id_list);
        /*
         * @TODO: inserire il vero controllo
         */

        return true;
    }

    /**
     * Each user can be associated with one or more user_profiles.
     *
     */
    public function user_profiles()
    {
        return $this->hasMany('Weeesh\UserProfile', 'id_user', 'id');
    }



}
