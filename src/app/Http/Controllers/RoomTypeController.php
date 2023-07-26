<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomType\IndexRoomTypeRequest;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Http\Requests\RoomType\UpdateRoomTypeRequest;
use App\Models\BuildingType;
use App\Models\RoomType;

class RoomTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(RoomType::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRoomTypeRequest $request)
    {
        $queryParams = $request->validated();
        $roomTypes = RoomType::sort($queryParams)
            ->paginate(8)
            ->withQueryString();
        return view('room-types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('room-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomTypeRequest $request)
    {
        $validatedData = $request->validated();
        RoomType::create($validatedData);
        return redirect()->route('room-types.index')
            ->with('status', 'room-type-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomType $roomType)
    {
        return view('room-types.show', compact('roomType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomType $roomType)
    {
        return view('room-types.edit', compact('roomType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomTypeRequest $request, RoomType $roomType)
    {
        $validatedData = $request->validated();
        $roomType->fill($validatedData)->save();
        return redirect()->route('room-types.show', $roomType->id)
            ->with('status', 'room-type-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->route('room-types.index')
            ->with('status', 'room-type-deleted');
    }
}
