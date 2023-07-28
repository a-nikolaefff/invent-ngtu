<?php

namespace App\Http\Controllers;

use App\Filters\RoomFilter;
use App\Http\Requests\Room\IndexRoomRequest;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Building;
use App\Models\Department;
use App\Models\DepartmentType;
use App\Models\Room;
use App\Models\RoomType;

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
            ->paginate(6)
            ->withQueryString();
        $roomTypes = RoomType::all();
        $buildings = Building::all();
        return view('rooms.index', compact('rooms', 'roomTypes', 'buildings'));
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
    public function show(Room $room)
    {
        $room->load('type', 'building', 'department');
        return view('rooms.show', compact('room'));
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
}
