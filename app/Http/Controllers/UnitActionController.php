<?php

namespace App\Http\Controllers;

use App\Models\UnitAction;
use Illuminate\Http\Request;

class UnitActionController extends Controller
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
        $unit_action = UnitAction::where([
            'section_student_id' => $request->section_student_id,
            'unit_id' => $request->unit_id,
        ])->first();
        if($unit_action){
            $unit_action->update($request->all());
        }else{
            UnitAction::create($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitAction  $unitAction
     * @return \Illuminate\Http\Response
     */
    public function show(UnitAction $unitAction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitAction  $unitAction
     * @return \Illuminate\Http\Response
     */
    public function edit(UnitAction $unitAction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitAction  $unitAction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnitAction $unitAction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitAction  $unitAction
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitAction $unitAction)
    {
        //
    }
}
