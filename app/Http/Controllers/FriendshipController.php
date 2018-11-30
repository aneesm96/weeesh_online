<?php

namespace Weeesh\Http\Controllers;

use Illuminate\Http\Request;
use Weeesh\Friendship;
use Auth;
use Illuminate\Support\Facades\DB;


/*
 * @TODO: da verificare e modificare - copiata da WlistController
 */
class FriendshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $id_user = Auth::user()->id;

        /*
         * recupero id_user_profile dalla tabella
         * in futuro potrebbe essere scelto dall'utente
         *
         */
        $id_user_profile = DB::table('user_profile')
            ->select('id_user_profile')
            ->where('id_user',$id_user)
            ->value('id_user_profile');

        //https://laravel.com/docs/5.5/queries#unions
        $first = DB::table('friendship as f')
            ->join('user_profile as up', 'f.id_user_profile_to','up.id_user_profile')
                        ->where('id_user_profile_by', $id_user_profile)
                        ->select('f.id_friendship','date_from', 'up.name', 'up.surname','id_user_profile_to as id_friend');
        //nella prima query non bisogna inserire il get(), in quanto serve solo la query

        $friendships = DB::table('friendship as f')
            ->join('user_profile as up', 'f.id_user_profile_by','up.id_user_profile')
            ->where('id_user_profile_to', $id_user_profile)
            ->union($first)
            ->select('f.id_friendship','date_from', 'up.name', 'up.surname','id_user_profile_by as id_friend')
            ->get();



        return view('friendship.index', compact('friendships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('wlist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $wlist = $this->validate(request(), [
            'name' => 'required',
            'id_list_privacy' => 'required|numeric',
        ]);

        $newWlist = WList::create($wlist);


        return \Redirect::route('wlists.show',
            array($newWlist->id_list))->with('success', __('List has been created'));
        //return back()->with('success', 'List has been created');;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_friendship)
    {
        //
        $friendship = Friendship::find($id_friendship);
        return view('friendship.show',compact('friendship','id_friendship'));



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id_list
     * @return \Illuminate\Http\Response
     */
    public function edit($id_list)
    {
        //
        $wlist = WList::find($id_list);
        return view('wlist.edit',compact('wlist','id_list'));

    }

    /**
     * Show the form for adding new row to the specified wlist.
     *
     * @param  int  $id_list
     * @return \Illuminate\Http\Response
     */
    public function addRow(Request $request, $id_list)
    {
        //vedi funzionamento edit
        $wlist = WList::find($id_list);
        return view('list_row.create',compact('wlist','id_list') );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_list
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_list)
    {
        $list = WList::find($id_list);
        $this->validate(request(), [
            'name' => 'required',
            //'id_user_profile_creator' => 'required|numeric',
            'id_list_privacy' => 'required|numeric'
        ]);
        $list->name = $request->get('name');
        //$list->id_user_profile_creator = $list->id_user_profile_creator;
        $list->id_list_privacy = $request->get('id_list_privacy');
        $list->save();
        return redirect('wlists')->with('success',__('List has been updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_list
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_list)
    {
        //
        $wlist = Wlist::find($id_list);
        $wlist->delete();
        return redirect('wlists')->with('success', __('List has been  deleted'));
    }



    /*
     * user: Francesco
     * date: 30/12/2017
     * time: 10:30
     *
     * check if 2 user_profiles are friends
     *
     * Return [{user_count:valore}]
     * per utilizzare il dato si può fare così
     *
     */
    public static function areFriends($id_user_profile_a, $id_user_profile_b){

        $id_friendship = DB::table('friendship')
            ->select(DB::raw('count(*) as user_count'))
            ->where('id_user_profile_by',"=",$id_user_profile_a, "and")
            ->where('id_user_profile_to', "=",$id_user_profile_b, "and")
            ->where('id_user_profile_by',"=",$id_user_profile_b,"or")
            ->where('id_user_profile_to',"=",$id_user_profile_a)
            ->get("user_count");

        return $id_friendship[0]->user_count;

    }
}