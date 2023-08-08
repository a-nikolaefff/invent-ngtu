<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepairType\IndexRepairTypeRequest;
use App\Http\Requests\RepairType\StoreRepairTypeRequest;
use App\Http\Requests\RepairType\UpdateRepairTypeRequest;
use App\Models\RepairType;

class RepairTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(RepairType::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRepairTypeRequest $request)
    {
        $queryParams = $request->validated();
        $repairTypes = RepairType::sort($queryParams)
            ->paginate(5)
            ->withQueryString();
        return view('repair-types.index', compact('repairTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('repair-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairTypeRequest $request)
    {
        $validatedData = $request->validated();
        $repairType = RepairType::create($validatedData);
        return redirect()->route('repair-types.show', $repairType->id)
            ->with('status', 'repair-type-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairType $repairType)
    {
        return view('repair-types.show', compact('repairType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairType $repairType)
    {
        return view('repair-types.edit', compact('repairType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairTypeRequest $request, RepairType $repairType)
    {
        $validatedData = $request->validated();
        $repairType->fill($validatedData)->save();
        return redirect()->route('repair-types.show', $repairType->id)
            ->with('status', 'repair-type-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairType $repairType)
    {
        $repairType->delete();
        return redirect()->route('repair-types.index')
            ->with('status', 'repair-type-deleted');
    }
}
