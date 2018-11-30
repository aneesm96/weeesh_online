<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 30/12/2017
 * Time: 12:16
 */

namespace Weeesh;
use Illuminate\Database\Eloquent\Model;

class FsRequestState  extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fs_request_state';
    protected $primaryKey='id_fs_request_state';

    public $timestamps = false;



}