<?php

namespace App\Http\Controllers;

use App\Filters\BuildingFilter;
use App\Filters\RoomFilter;
use App\Http\Requests\Building\IndexBuildingRequest;
use App\Http\Requests\Building\ShowBuildingRequest;
use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Requests\Images\StoreImageRequest;
use App\Models\Building;
use App\Models\BuildingType;
use App\Models\Equipment;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Building::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexBuildingRequest $request)
    {
        $queryParams = $request->validated();
        $filter = app()->make(
            BuildingFilter::class,
            ['queryParams' => $queryParams]
        );

        $buildings = Building::select('buildings.*')
            ->leftjoin(
                'building_types',
                'buildings.building_type_id',
                '=',
                'building_types.id'
            )
            ->with(
                'type',
            )
            ->filter($filter)
            ->sort($queryParams)
            ->paginate(5)
            ->withQueryString();
        $buildingTypes = BuildingType::all();
        return view('buildings.index', compact('buildings', 'buildingTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buildingTypes = BuildingType::all();
        return view('buildings.create', compact('buildingTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request)
    {
        $validatedData = $request->validated();
        Building::create($validatedData);
        return redirect()->route('buildings.index')
            ->with('status', 'building-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowBuildingRequest $request, Building $building)
    {
        $building->load('type');

        $queryParams = $request->validated();

        $filter = app()->make(
            RoomFilter::class,
            ['queryParams' => $queryParams]
        );

        $rooms = null;
        if ($building->rooms->count() === 0) {
            $rooms = $building->rooms;
        } else {
            $rooms = Room::where('building_id', $building->id)
                ->select('rooms.*')
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
                ->with('type', 'department')
                ->filter($filter)
                ->sort($queryParams)
                ->paginate(5)
                ->withQueryString();
        }

        $roomTypes = RoomType::all();
        $floorAmount = $building->floor_amount;

        return view(
            'buildings.show',
            compact(
                'building',
                'rooms',
                'roomTypes',
                'floorAmount'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        $building->load('type');
        $buildingTypes = BuildingType::all();
        return view('buildings.edit', compact('building', 'buildingTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building)
    {
        $validatedData = $request->validated();
        $building->fill($validatedData)->save();
        return redirect()->route('buildings.show', $building->id)
            ->with('status', 'building-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('buildings.index')
            ->with('status', 'building-deleted');
    }

    /**
     * Returns the floor amount of the building in JSON format.
     *
     * @param Request $request The request object.
     *
     * @return JsonResponse The JSON response with customer data.
     */
    public function floorAmount(Request $request): JsonResponse
    {
        $buildingId = $request->input('id');
        $floorAmount = Building::findOrFail($buildingId)->floor_amount;
        return response()->json($floorAmount);
    }

    /**
     * Store a new image.
     */
    public function storeImages(
        StoreImageRequest $request,
        Building $building
    ) {
        $this->authorize('view', $building);
        $files = $request->file('images');

        foreach ($files as $file) {
            $building->addMedia($file)
                ->withCustomProperties([
                    'user_id' => Auth::user()->id,
                    'user_name' => Auth::user()->name,
                    'datetime' => Carbon::now()->format('d.m.Y H:i:s')
                ])
                ->toMediaCollection('images');
        }

        return redirect()->route('buildings.show', $building->id)
            ->with('status', 'images-stored');
    }

    /**
     * Remove the image
     */
    public function destroyImage(Request $request, Building $building)
    {
        $this->authorize('view', $building);

        $images = $building->getMedia('images');
        $imageIndex = $request->get('image_index');
        $images[$imageIndex]->delete();
        return redirect()->route('buildings.show', $building->id)
            ->with('status', 'image-deleted');
    }
}
