<?php

namespace App\Http\Controllers;

use App\Models\UnitItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $unit_items = UnitItem::where('unit_id', $request->unit_id)->get();
        $total_items = UnitItem::select([
            'grading_system_id',
            'grading_systems.percentage',
            'grading_systems.name',
            DB::raw('SUM(item) as total_items'),
            DB::raw('ROUND(((SUM(item) / SUM(item)) * 100), 2) as percentage_score'),
            DB::raw('(((SUM(item) / SUM(item)) * 100) * grading_systems.percentage) as weighted_score'),
        ])
        ->where('unit_id', $request->unit_id)
        ->groupBy('grading_system_id')
        ->join('grading_systems', 'unit_items.grading_system_id', '=', 'grading_systems.id')
        ->get();

        foreach ($total_items as $key => $total_item) {
            $total_item->unit_items = UnitItem::where('unit_id', $request->unit_id)->where('grading_system_id', $total_item->grading_system_id)->get();
            $total_item->count = count($total_item->unit_items);
        }
        return $total_items;
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
        $unit_item = UnitItem::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitItem  $unitItem
     * @return \Illuminate\Http\Response
     */
    public function show(UnitItem $unitItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitItem  $unitItem
     * @return \Illuminate\Http\Response
     */
    public function edit(UnitItem $unitItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitItem  $unitItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnitItem $unitItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitItem  $unitItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UnitItem::findOrFail($id)->delete();
    }
}
