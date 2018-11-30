<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 28/12/2017
 * Time: 21:00
 *
 *
 */

namespace Weeesh\Http\Controllers;

use Weeesh\UserProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (\Auth::check()) {
            // The user is logged in

            $user_profile = UserProfile::all();

            $search = \Request::get('search');  //the param of URI

            $user_profiles = UserProfile::where('name', 'like', '%' . $search . '%')
                ->orderBy('name')
                ->paginate(20);

            //$user_profiles = UserProfile::search()->orderBy('name')->paginate(20);

            return view('user_profile.index', compact('user_profiles'))->withuser($user_profile);
        }else {
            // The user is NOT logged in
            return view("/welcome");
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function friendShow($is_user_profile, $id_list)
    {
        //
        $wlist = WList::find($id_list);
        return view('wlist.show',compact('wlist','id_list'));

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id_user_profile
     * @return \Illuminate\Http\Response
     */
    public function show($id_user_profile)
    {
        //
        $userProfile = UserProfile::find($id_user_profile);
        return view('user_profile.show',compact('userProfile','id_user_profile'));

    }


}