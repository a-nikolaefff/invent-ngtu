<?php

namespace App\Http\Controllers;

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
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        $equipment = Equipment::getByParams($queryParams)
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
    public function store(StoreEquipmentRequest $request, EquipmentService $equipmentService)
    {
        $equipment = $equipmentService->create($request->validated());

        return redirect()->route('equipment.show', $equipment->id)
            ->with('status', 'equipment-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowEquipmentRequest $request, Equipment $equipment)
    {
        $equipment->load('type', 'room', 'room.department', 'room.building');

        $queryParams = $request->validated();

        $repairs = Repair::getByParamsAndEquipment($queryParams, $equipment)
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
    public function update(UpdateEquipmentRequest $request, EquipmentService $equipmentService, Equipment $equipment)
    {
        $equipmentService->update($equipment, $request->validated());

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
     * @return JsonResponse The JSON response with customer data.
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $keyword = $request->input('search');

        $equipment = Equipment::where('number', 'ilike', "%$keyword%")
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
        Equipment         $equipment
    )
    {
        $this->authorize('manageImages', $equipment);
        $files = $request->file('images');
        $equipment->storeMedia($files, 'images');

        return redirect()->route('equipment.show', $equipment->id)
            ->with('status', 'images-stored');
    }

    /**
     * Remove the image
     */
    public function destroyImage(Request $request, Equipment $equipment)
    {
        $this->authorize('manageImages', $equipment);

        $images = $equipment->getMedia('images');
        $imageIndex = $request->get('image_index');
        $images[$imageIndex]->delete();

        return redirect()->route('equipment.show', $equipment->id)
            ->with('status', 'image-deleted');
    }
}
