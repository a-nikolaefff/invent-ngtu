<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Filters\EquipmentFilter;
use App\Filters\RoomFilter;
use App\Http\Requests\Equipment\IndexEquipmentRequest;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Models\Building;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Equipment::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexEquipmentRequest $request)
    {
        $queryParams = $request->validated();
        $filter = app()->make(
            EquipmentFilter::class,
            ['queryParams' => $queryParams]
        );

        $equipment = Equipment::select('equipment.*')
            ->leftjoin(
                'equipment_types',
                'equipment.equipment_type_id',
                '=',
                'equipment_types.id'
            )
            ->leftjoin(
                'rooms',
                'equipment.room_id',
                '=',
                'rooms.id'
            )
            ->leftjoin(
                'buildings',
                'rooms.building_id',
                '=',
                'buildings.id'
            )
            ->leftjoin(
                'departments',
                'rooms.department_id',
                '=',
                'departments.id'
            )
            ->with(
                'type',
                'room',
                'room.building',
                'room.department',
            )
            ->when(
                Auth::user()->hasRole(UserRoleEnum::Employee),
                function ($query) {
                    return $query->whereIn(
                        'rooms.department_id',
                        Auth::user()->department->getSelfAndDescendants()
                            ->pluck('id')->toArray()
                    );
                }
            )
            ->filter($filter)
            ->sort($queryParams)
            ->paginate(5)
            ->withQueryString();

        $equipmentTypes = EquipmentType::all();
        return view(
            'equipment.index',
            compact(
                'equipment',
                'equipmentTypes',
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $room = Room::with('building')->find($request->get('room_id'));
        $equipmentTypes = EquipmentType::all();
        return view('equipment.create', compact('equipmentTypes', 'room'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['not_in_operation'] = $validatedData['not_in_operation']
            ?? false;
        $validatedData['decommissioned'] = $validatedData['decommissioned'] ??
            false;;
        $validatedData['decommissioning_date']
            = $validatedData['decommissioned']
            ? $validatedData['decommissioning_date'] : null;
        $validatedData['decommissioning_reason']
            = $validatedData['decommissioned']
            ? $validatedData['decommissioning_reason'] : null;

        Equipment::create($validatedData);
        return redirect()->route('equipment.index')
            ->with('status', 'equipment-stored');
    }


    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        $equipment->load('type', 'room', 'room.department', 'room.building');
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $equipment->load('type', 'room', 'room.department', 'room.building');
        $equipmentTypes = EquipmentType::all();
        return view('equipment.edit', compact('equipment', 'equipmentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateEquipmentRequest $request,
        Equipment $equipment
    ) {
        $validatedData = $request->validated();

        $validatedData['not_in_operation'] = $validatedData['not_in_operation']
            ?? false;
        $validatedData['decommissioned'] = $validatedData['decommissioned'] ??
            false;;
        $validatedData['decommissioning_date']
            = $validatedData['decommissioned']
            ? $validatedData['decommissioning_date'] : null;
        $validatedData['decommissioning_reason']
            = $validatedData['decommissioned']
            ? $validatedData['decommissioning_reason'] : null;

        $equipment->fill($validatedData)->save();
        return redirect()->route('equipment.show', $equipment->id)
            ->with('status', 'equipment-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipment.index')
            ->with('status', 'equipment-deleted');
    }
}
