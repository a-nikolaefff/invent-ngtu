<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Filters\EquipmentFilter;
use App\Filters\RepairFilter;
use App\Http\Requests\Equipment\CreateEquipmentRequest;
use App\Http\Requests\Equipment\IndexEquipmentRequest;
use App\Http\Requests\Equipment\ShowEquipmentRequest;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Http\Requests\Images\StoreImageRequest;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Repair;
use App\Models\RepairStatus;
use App\Models\RepairType;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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
    public function create(CreateEquipmentRequest $request)
    {
        $validatedData = $request->validated();
        $chosenRoom = Room::with('building')->find(
            $validatedData['room_id'] ?? null
        );
        $equipmentTypes = EquipmentType::all();
        return view(
            'equipment.create',
            compact('equipmentTypes', 'chosenRoom')
        );
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
    public function show(ShowEquipmentRequest $request, Equipment $equipment)
    {
        $equipment->load('type', 'room', 'room.department', 'room.building');

        $queryParams = $request->validated();
        $filter = app()->make(
            RepairFilter::class,
            ['queryParams' => $queryParams]
        );

        $repairs = Repair::select('repairs.*')
            ->where('repairs.equipment_id', $equipment->id)
            ->leftjoin(
                'repair_types',
                'repairs.repair_type_id',
                '=',
                'repair_types.id'
            )
            ->with('type', 'status',)
            ->filter($filter)
            ->sort($queryParams)
            ->paginate(5)
            ->withQueryString();

        $repairTypes = RepairType::all();
        $repairStatuses = RepairStatus::all();

        return view(
            'equipment.show',
            compact('equipment', 'repairs', 'repairTypes', 'repairStatuses')
        );
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

    /**
     * Returns the result of a search for equipment in JSON format.
     *
     * @param Request $request The request object.
     *
     * @return JsonResponse The JSON response with customer data.
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $keyword = $request->input('search');

        $equipment = Equipment::where('number', 'like', "%$keyword%")
            ->get()->toArray();

        for ($i = 0; $i < count($equipment); $i++) {
            $equipment[$i]['number'] = '№ ' . $equipment[$i]['number'] . ', '
                . $equipment[$i]['name'];
        }
        return response()->json($equipment);
    }

    /**
     * Store a new image.
     */
    public function storeImages(
        StoreImageRequest $request,
        Equipment $equipment
    ) {
        $this->authorize('view', $equipment);
        $files = $request->file('images');

        foreach ($files as $file) {
            $equipment->addMedia($file)
                ->withCustomProperties([
                    'user_id' => Auth::user()->id,
                    'user_name' => Auth::user()->name,
                    'datetime' => Carbon::now()->format('d.m.Y H:i:s')
                ])
                ->toMediaCollection('images');
        }

        return redirect()->route('equipment.show', $equipment->id)
            ->with('status', 'images-stored');
    }

    /**
     * Remove the image
     */
    public function destroyImage(Request $request, Equipment $equipment)
    {
        $this->authorize('view', $equipment);

        $images = $equipment->getMedia('images');
        $imageIndex = $request->get('image_index');
        $images[$imageIndex]->delete();
        return redirect()->route('equipment.show', $equipment->id)
            ->with('status', 'image-deleted');
    }
}
