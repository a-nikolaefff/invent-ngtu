<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Http\Requests\Building\IndexBuildingRequest;
use App\Http\Requests\Building\ShowBuildingRequest;
use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Requests\Images\StoreImageRequest;
use App\Models\Building;
use App\Models\BuildingType;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
    public function index(IndexBuildingRequest $request): View
    {
        return view('buildings.index', [
            'buildings' => Building::getByParams($request->validated())->paginate(5)->withQueryString(),
            'buildingTypes' => BuildingType::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('buildings.create', ['buildingTypes' => BuildingType::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request)
    {
        $data = $request->validated();
        if (isset($data['model'])) {
            $data['model'] = $this->storeModel($data['model']);
        }

        $building = Building::create($data);

        return redirect()->route('buildings.show', $building->id)
            ->with('status', 'building-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowBuildingRequest $request, Building $building)
    {
        $rooms = Room::getByParamsAndBuilding($request->validated(), $building)
            ->paginate(5)
            ->withQueryString();

        return view(
            'buildings.show',
            [
                'building' => $building,
                'rooms' => $rooms,
                'roomTypes' => RoomType::all(),
                'floorAmount' => $building->floor_amount,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        return view('buildings.edit',
            [
                'building' => $building,
                'buildingTypes' => BuildingType::all(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building)
    {
        $data = $request->validated();

        if (isset($data['delete_model']) && $data['delete_model'] === 'on') {
            $this->deleteModel($building->model);
            $data['model'] = null;
        } else if (isset($data['model'])) {
            if ($building->model) {
                $this->deleteModel($building->model);
            }
            $data['model'] = $this->storeModel($data['model']);
        }

        $building->fill($data)->save();

        return redirect()->route('buildings.show', $building->id)
            ->with('status', 'building-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        if ($building->model) {
            $this->deleteModel($building->model);
        }
        $building->delete();

        return redirect()->route('buildings.index')
            ->with('status', 'building-deleted');
    }

    /**
     * Returns the floor amount of the building in JSON format.
     *
     * @param Request $request The request object.
     * @return JsonResponse The JSON response with customer data.
     */
    public function floorAmount(Request $request): JsonResponse
    {
        $floorAmount = Building::findOrFail($$request->input('id'))->floor_amount;

        return response()->json($floorAmount);
    }

    /**
     * Store a new image.
     */
    public function storeImages(StoreImageRequest $request, Building $building)
    {
        $this->authorize('manageImages', $building);

        $building->storeMedia($request->file('images'), 'images');

        return redirect()->route('buildings.show', $building->id)
            ->with('status', 'images-stored');
    }

    /**
     * Remove the image
     */
    public function destroyImage(Request $request, Building $building)
    {
        $this->authorize('manageImages', $building);

        $imageIndex = $request->get('image_index');
        $image = $building->getMedia('images')->get($imageIndex);
        $image?->delete();

        return redirect()->route('buildings.show', $building->id)
            ->with('status', 'image-deleted');
    }

    public function viewModel(Building $building)
    {
        $a =  $building->load('roomsWithGeometry.type');

        return view('buildings.model',
            [
                'building' => $building->load('roomsWithGeometry.type')
            ]
        );
    }

    private function storeModel(UploadedFile $file): string
    {
        $fileName = FileHelper::generateUniqueFileName($file);
        Storage::putFileAs('models/buildings/', $file, $fileName);

        return $fileName;
    }

    private function deleteModel(string $fileName): void
    {
        Storage::delete('models/buildings/' . $fileName);
    }
}
