<?php

namespace Weeesh\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Weeesh\User;
use Weeesh\UserProfile;
use Weeesh\WList;
use Auth;
use Illuminate\Support\Facades\DB;

class WListController extends Controller
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
            'image' => 'nullable|mimes:jpeg,jpg |max:4096',
            'date_valide_to' => 'nullable|date',
            ],
                $messages = [
                    'mimes' => 'Tipo file permessi: jpeg',
                    'name.required' => 'Il nome è obbligatorio',
                ]
        );

        $newWlist = WList::create($wlist);

        $file = $request->file("image");
        $filename = $newWlist->id_list . ".jpg";

        if($file){
            Storage::disk('wlist')->put($filename,File::get($file));
        }


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
        $wlist = WList::find($id_list);
        return view('wlist.show',compact('wlist','id_list'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function friend_show($id_user_profile, $id_list)
    {
        //
        //
        $wlist = WList::find($id_list);
        $userProfile = UserProfile::find($id_user_profile);
        return view('wlist.friendShow',compact('wlist','id_list','userProfile','id_user_profile'));

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