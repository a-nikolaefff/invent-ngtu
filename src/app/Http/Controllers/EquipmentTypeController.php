<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentType\IndexEquipmentTypeRequest;
use App\Http\Requests\EquipmentType\StoreEquipmentTypeRequest;
use App\Http\Requests\EquipmentType\UpdateEquipmentTypeRequest;
use App\Models\EquipmentType;

class EquipmentTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(EquipmentType::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexEquipmentTypeRequest $request)
    {
        $queryParams = $request->validated();
        $equipmentTypes = EquipmentType::sort($queryParams)
            ->paginate(5)
            ->withQueryString();
        return view('equipment-types.index', compact('equipmentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipment-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentTypeRequest $request)
    {
        $validatedData = $request->validated();
        EquipmentType::create($validatedData);
        return redirect()->route('equipment-types.index')
            ->with('status', 'equipment-type-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentType $equipmentType)
    {
        return view('equipment-types.show', compact('equipmentType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipmentType $equipmentType)
    {
        return view('equipment-types.edit', compact('equipmentType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipmentType)
    {
        $validatedData = $request->validated();
        $equipmentType->fill($validatedData)->save();
        return redirect()->route('equipment-types.show', $equipmentType->id)
            ->with('status', 'equipment-type-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentType $equipmentType)
    {
        $equipmentType->delete();
        return redirect()->route('equipment-types.index')
            ->with('status', 'equipment-type-deleted');
    }
}
