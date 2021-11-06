<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ip;
use App\Models\Label;
use Redirect;


class DashboardController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $ip = new Ip;
        $ip->ip_address = $request->ip_address;
        $ip->label = $request->label;
        $label = new Label(['label' => $request->label, 'action'=> 'Added', 'user_id' => $user->id]);
        $ip->save();
        $ip->labels()->save($label);
        return Redirect::route('dashboard',$ip->id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user = auth()->user();
        $ip = Ip::find($id);
        $ip->label = $request->label;
        $label = new Label(['label' => $request->label, 'action'=> 'Updated', 'user_id' => $user->id]);
        $ip->save();
        $ip->labels()->save($label);
        return Redirect::route('dashboard',$ip->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
