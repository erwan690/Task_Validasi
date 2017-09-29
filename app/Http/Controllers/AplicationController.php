<?php

namespace App\Http\Controllers;

use App\Aplication;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\JobRequest;

class AplicationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','role:user']);
    }
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

      $aplication = new Aplication;
      $aplication->name = $request->name_file;
      $aplication->user_id = Auth::user()->id;
      if ($request->lamaran) {
          $file = $request->file('lamaran');
          $input['filename'] = time().'.'.$file->getClientOriginalExtension();
          $destinationPath = public_path('/upload');
          $file->move($destinationPath, $input['filename']);
          $aplication->filename = $input['filename'];
        }
        $aplication->save();
        return redirect()->route('home');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aplication  $aplication
     * @return \Illuminate\Http\Response
     */
    public function show(Aplication $aplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aplication  $aplication
     * @return \Illuminate\Http\Response
     */
    public function edit(Aplication $aplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aplication  $aplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aplication $aplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aplication  $aplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aplication $aplication)
    {
        //
    }
}
