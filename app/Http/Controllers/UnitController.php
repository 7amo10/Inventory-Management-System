<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use Str;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::where("user_id", auth()->id())->select(['id', 'name', 'slug', 'short_code'])
            ->get();

        return view('units.index', [
            'units' => $units,
        ]);
    }

    public function create()
    {
    }

    public function show(Unit $unit)
    {

    }

    public function store(StoreUnitRequest $request)
    {

    }

    public function edit(Unit $unit)
    {

    }

    public function update(UpdateUnitRequest $request, $slug)
    {

    }

    public function destroy(Unit $unit)
    {

    }
}
