<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\IndexDepartmentRequest;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\DepartmentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Department::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexDepartmentRequest $request)
    {
        return view('departments.index',
            [
                'departments' => Department::getByParams($request->validated())->paginate(5)->withQueryString(),
                'departmentTypes' => DepartmentType::all(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create', ['departmentTypes' => DepartmentType::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create($request->validated());

        return redirect()->route('departments.show', $department->id)
            ->with('status', 'department-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load('type', 'parent', 'children');

        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $department->load('type', 'parent');

        return view('departments.edit', [
            'department' => $department,
            'departmentTypes' => DepartmentType::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated())->save();

        return redirect()->route('departments.show', $department->id)
            ->with('status', 'department-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('status', 'department-deleted');
    }

    /**
     * Returns the result of a search for customers in JSON format.
     *
     * @param  Request  $request The request object.
     * @return JsonResponse The JSON response with customer data.
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $departments = Department::searchByNameOrShortName($request->input('search', ''))->get();

        return response()->json($departments);
    }
}
