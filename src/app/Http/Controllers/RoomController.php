<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Filters\RoomFilter;
use App\Http\Requests\Equipment\IndexEquipmentRequest;
use App\Http\Requests\Room\IndexRoomRequest;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Building;
use App\Models\Department;
use App\Models\DepartmentType;
use App\Models\Equipment;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Room::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRoomRequest $request)
    {
        $queryParams = $request->validated();
        $filter = app()->make(
            RoomFilter::class,
            ['queryParams' => $queryParams]
        );

        $rooms = Room::select('rooms.*')
            ->leftjoin(
                'room_types',
                'rooms.room_type_id',
                '=',
                'room_types.id'
            )
            ->leftjoin(
                'departments',
                'rooms.department_id',
                '=',
                'departments.id'
            )
            ->leftjoin(
                'buildings',
                'rooms.building_id',
                '=',
                'buildings.id'
            )
            ->with(
                'type',
                'department',
                'building',
            )
            ->filter($filter)
            ->sort($queryParams)
            ->paginate(5)
            ->withQueryString();
        $roomTypes = RoomType::all();
        $buildings = Building::all();
        $floorAmount = -1;
        if (isset($queryParams['building_id'])) {
            $floorAmount = Building::findOrFail($queryParams['building_id'])
                ->floor_amount;;
        }
        return view(
            'rooms.index',
            compact(
                'rooms',
                'roomTypes',
                'buildings',
                'floorAmount'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTypes = RoomType::all();
        $buildings = Building::all();
        return view('rooms.create', compact('roomTypes', 'buildings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $validatedData = $request->validated();
        Room::create($validatedData);
        return redirect()->route('rooms.index')
            ->with('status', 'room-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(IndexEquipmentRequest $request, Room $room)
    {
        $queryParams = $request->validated();

        $room->load('type', 'building', 'department', 'equipment');
        $a = $room->equipment->count();


        $equipment = null;
        if ($room->equipment->count() === 0) {
            $equipment = $room->equipment;
        } else if ($request->user()->can('view', $room->equipment->first())) {
            $equipment = Equipment::where('room_id', $room->id)
                ->select('equipment.*')
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
                ->sort($queryParams)
                ->paginate(5)
                ->withQueryString();
        }

        return view('rooms.show', compact('room', 'equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $room->load('type', 'building', 'department');
        $roomTypes = RoomType::all();
        $buildings = Building::all();
        return view(
            'rooms.edit',
            compact('room', 'roomTypes', 'buildings')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $validatedData = $request->validated();
        $room->fill($validatedData)->save();
        return redirect()->route('rooms.show', $room->id)
            ->with('status', 'room-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')
            ->with('status', 'room-deleted');
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

        $rooms = Room::with('building')
            ->where('number', 'like', "%$keyword%")
            ->get()->toArray();

        for ($i = 0; $i < count($rooms); $i++) {
            $rooms[$i]['number'] = $rooms[$i]['number'] . ' ('
                . $rooms[$i]['building']['name'] . ')';
        }
        return response()->json($rooms);
    }
}
