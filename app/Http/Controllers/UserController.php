<?php
/**
 * Created by PhpStorm.
 * User: FRANCESCO
 * Date: 26/12/2017
 * Time: 22:16
 */

namespace Weeesh\Http\Controllers;

use Illuminate\Http\Request;
use Weeesh\User;
use Auth;
use Illuminate\Support\Facades\DB;

/*
 * @TODO: Classe copiata da WlistController - Da verificare e modificare
 */

class UserController extends Controller
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
        $id_user_profile_creator = DB::table('user_profile')
            ->select('id_user_profile')
            ->where('id_user',$id_user)
            ->value('id_user_profile');

        $wlists = WList::all()->where('id_user_profile_creator',$id_user_profile_creator);

        return view('wlist.index', compact('wlists'));
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
    public function show($id_list)
    {
        //
        $wlist = User::find($id_list);
        return view('wlist.show',compact('wlist','id_list'));


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
}