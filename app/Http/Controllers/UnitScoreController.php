<?php

namespace App\Http\Controllers;

use App\Models\UnitScore;
use Illuminate\Http\Request;

class UnitScoreController extends Controller
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
        $unit_score = UnitScore::where([
            ['unit_id', '=', $request->unit_id],
            ['unit_item_id', '=', $request->unit_item_id],
            ['section_student_id', '=', $request->section_student_id],
            ['grading_system_id', '=', $request->grading_system_id],
        ])->first();
        
        if($unit_score){
            $unit_score->update($request->all());
        }else{
            $unit_score = UnitScore::create($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitScore  $unitScore
     * @return \Illuminate\Http\Response
     */
    public function show(UnitScore $unitScore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitScore  $unitScore
     * @return \Illuminate\Http\Response
     */
    public function edit(UnitScore $unitScore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitScore  $unitScore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnitScore $unitScore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitScore  $unitScore
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitScore $unitScore)
    {
        //
    }
}
