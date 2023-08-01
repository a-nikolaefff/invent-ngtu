<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentType\IndexDepartmentTypeRequest;
use App\Http\Requests\DepartmentType\StoreDepartmentTypeRequest;
use App\Http\Requests\DepartmentType\UpdateDepartmentTypeRequest;
use App\Models\DepartmentType;
use App\Models\User;

class DepartmentTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(DepartmentType::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexDepartmentTypeRequest $request)
    {
        $queryParams = $request->validated();
        $departmentTypes = DepartmentType::sort($queryParams)
            ->paginate(10)
            ->withQueryString();
        return view('department-types.index', compact('departmentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentTypeRequest $request)
    {
        $validatedData = $request->validated();
        DepartmentType::create($validatedData);
        return redirect()->route('department-types.index')
            ->with('status', 'department-type-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentType $departmentType)
    {
        return view('department-types.show', compact('departmentType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentType $departmentType)
    {
        return view('department-types.edit', compact('departmentType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateDepartmentTypeRequest $request,
        DepartmentType $departmentType
    ) {
        $validatedData = $request->validated();
        $departmentType->fill($validatedData)->save();
        return redirect()->route('department-types.show', $departmentType->id)
            ->with('status', 'department-type-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentType $departmentType)
    {
        $departmentType->delete();
        return redirect()->route('department-types.index')
            ->with('status', 'department-type-deleted');
    }
}
