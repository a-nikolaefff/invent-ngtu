<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuildingType\IndexBuildingTypeRequest;
use App\Http\Requests\BuildingType\StoreBuildingTypeRequest;
use App\Http\Requests\BuildingType\UpdateBuildingTypeRequest;
use App\Models\BuildingType;

class BuildingTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(BuildingType::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexBuildingTypeRequest $request)
    {
        return view('building-types.index', [
            'buildingTypes' => BuildingType::sort($request->validated())->paginate(5)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('building-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingTypeRequest $request)
    {
        $buildingType = BuildingType::create($request->validated());

        return redirect()->route('building-types.show', $buildingType->id)
            ->with('status', 'building-type-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(BuildingType $buildingType)
    {
        return view('building-types.show', compact('buildingType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BuildingType $buildingType)
    {
        return view('building-types.edit', compact('buildingType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingTypeRequest $request, BuildingType $buildingType)
    {
        $buildingType->fill($request->validated())->save();

        return redirect()->route('building-types.show', $buildingType->id)
            ->with('status', 'building-type-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BuildingType $buildingType)
    {
        $buildingType->delete();

        return redirect()->route('building-types.index')
            ->with('status', 'building-type-deleted');
    }
}
