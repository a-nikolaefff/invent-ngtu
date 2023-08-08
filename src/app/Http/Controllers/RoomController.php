<?php

namespace App\Http\Controllers;

use App\Filters\EquipmentFilter;
use App\Filters\RoomFilter;
use App\Http\Requests\Images\StoreImageRequest;
use App\Http\Requests\Room\CreateRoomRequest;
use App\Http\Requests\Room\IndexRoomRequest;
use App\Http\Requests\Room\ShowRoomRequest;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Building;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
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

        $rooms = Room::getByParams($queryParams)
            ->paginate(5)
            ->withQueryString();
        $roomTypes = RoomType::all();
        $buildings = Building::all();

        $floorAmount = -1;
        if (isset($queryParams['building_id'])) {
            $floorAmount = Building::find($queryParams['building_id'])
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
    public function create(CreateRoomRequest $request)
    {
        $validatedData = $request->validated();
        $chosenBuilding = Building::find($validatedData['building_id'] ?? null);
        $roomTypes = RoomType::all();
        $buildings = Building::all();
        return view(
            'rooms.create',
            compact('roomTypes', 'buildings', 'chosenBuilding')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $validatedData = $request->validated();
        $room = Room::create($validatedData);
        return redirect()->route('rooms.show', $room->id)
            ->with('status', 'room-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowRoomRequest $request, Room $room)
    {
        $room->load('type', 'building', 'department', 'equipment');

        $queryParams = $request->validated();

        $equipment = null;
        if ($room->equipment->count() === 0) {
            $equipment = $room->equipment;
        } else {
            if ($request->user()->can('view', $room->equipment->first())) {
                $equipment = Equipment::getByParamsAndRoom($queryParams, $room)
                    ->paginate(5)
                    ->withQueryString();
            }
        }

        $equipmentTypes = EquipmentType::all();

        return view(
            'rooms.show',
            compact('room', 'equipment', 'equipmentTypes')
        );
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

    /**
     * Store a new image.
     */
    public function storeImages(
        StoreImageRequest $request,
        Room $room
    ) {
        $this->authorize('manageImages', $room);
        $files = $request->file('images');
        $room->storeMedia($files, 'images');

        return redirect()->route('rooms.show', $room->id)
            ->with('status', 'images-stored');
    }

    /**
     * Remove the image
     */
    public function destroyImage(Request $request, Room $room)
    {
        $this->authorize('manageImages', $room);

        $images = $room->getMedia('images');
        $imageIndex = $request->get('image_index');
        $images[$imageIndex]->delete();
        return redirect()->route('rooms.show', $room->id)
            ->with('status', 'image-deleted');
    }
}
