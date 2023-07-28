<?php

namespace App\Http\Controllers;

use App\Filters\DepartmentFilter;
use App\Http\Requests\Department\IndexDepartmentRequest;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\DepartmentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request ;

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
        $queryParams = $request->validated();
        $filter = app()->make(
            DepartmentFilter::class,
            ['queryParams' => $queryParams]
        );

        $departments = Department::select('departments.*')
            ->leftjoin(
                'departments as parent_departments',
                'departments.parent_department_id',
                '=',
                'parent_departments.id'
            )
            ->leftjoin(
                'department_types',
                'departments.department_type_id',
                '=',
                'department_types.id'
            )
            ->with(
                'parent',
                'type',
            )
            ->filter($filter)
            ->sort($queryParams)
            ->paginate(6)
            ->withQueryString();
        $departmentTypes = DepartmentType::all();
        return view('departments.index', compact('departments', 'departmentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departmentTypes = DepartmentType::all();
        return view('departments.create', compact('departmentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $validatedData = $request->validated();
        Department::create($validatedData);
        return redirect()->route('departments.index')
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
        $departmentTypes = DepartmentType::all();
        return view('departments.edit', compact('department', 'departmentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $validatedData = $request->validated();
        $department->fill($validatedData)->save();
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
     * @param Request $request The request object.
     *
     * @return JsonResponse The JSON response with customer data.
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $keyword = $request->input('search');

        $departments = Department::where('name', 'like', "%$keyword%")
                    ->orWhere('short_name', 'like', "%$keyword%")
            ->get();

        return response()->json($departments);
    }
}
