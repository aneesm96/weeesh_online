<?php

namespace Weeesh;

use Illuminate\Database\Eloquent\Model;

class ListPrivacy extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'list_privacy';
    protected $primaryKey='id_list_privacy';



    /*
     * https://laracasts.com/discuss/channels/laravel/how-to-obtain-data-from-another-table-using-foreign-key-in-view?page=1
     */
    public function wlists() {
        $this->hasMany('\App\Models\WList');
    }


}
