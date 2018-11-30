<?php

namespace Weeesh\Http\Controllers;

use Illuminate\Http\Request;
use Weeesh\ListRow;
use Weeesh\WList;
use Auth;


class ListRowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Present the form used to create a new list row
     *
     * @param integer $id_list The candidate task's parent list ID
     * @return Response
     */
    public function create($id_list)
    {
        //$user = User::find(Auth::id());
        //@TODO: inserire il controllo se sono il proprietario della lista anche in altri metodi

        $wlist = WList::findOrFail($id_list);
        return view('list_row.create')->with('wlist', $wlist);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id_list, Request $request)
    {


        $list_row = $this->validate(request(), [

            'object' => 'required',
            'id_list_privacy' => 'required|numeric',
            'id_list'=>'required|numeric',
            'link_web',

        ]);

        ListRow::create($list_row);

        $wlist = WList::findOrFail($id_list);

        return \Redirect::route('wlists.show', array($wlist->id_list))
            ->with('success', __('Your object has been inserted!'));

        //return back()->with('success', 'Row has been added');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id_list
     * @param  int  $id_list_row
     * @return Response
     */
    public function edit($id_list, $id_list_row)
    {
        $user = \Auth::user();
        $list_row = ListRow::findOrFail($id_list_row);
        if ($user->owns($list_row->id_list))
        {
            return view('list_row.edit')->with('list_row', $list_row);

        } else {
            return \Redirect::route('wlists.index')
                ->with('message', __('Permissions error!'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_list
     * @param  int $id_list_row
     * @return \Illuminate\Http\Response
     */
    public function update($id_list, $id_list_row, Request $request)
    {
        //$user = Auth::user();
        $list_row = ListRow::findOrFail($id_list_row);
        //if ($user->owns($list_row->id_list))
       // {
        $list_row->update([
                'object' => $request->get('object'),
                'link_web' => $request->get('link_web'),
                'id_list_privacy' => $request->get('id_list_privacy'),
            ]);

            return \Redirect::route('wlists.list_rows.edit',
                array($list_row->id_list, $list_row->id_list_row))->with('success', __("Your object has been updated!"));
        /*
        } else {
            return \Redirect::route('lists.index')
                ->with('message', 'Permissions error!');

        }
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_list, $id_list_row)
    {
        //@TODO: verifica che sia l'utente corretto


        //
        $list_row = ListRow::find($id_list_row);
        $list_row->delete();

        $wlist = Wlist::findOrFail($id_list);

        return \Redirect::route('wlists.show', [$wlist->id_list])
            ->with('success', __('Object deleted!'));


        //return redirect('wlists')->with('success','List has been  deleted');
    }
}
