<?php

namespace App\Http\Controllers;

use App\Enums\RepairApplicationStatusEnum;
use App\Enums\UserRoleEnum;
use App\Filters\RepairApplicationFilter;
use App\Http\Requests\Images\StoreImageRequest;
use App\Http\Requests\RepairApplication\CreateRepairtApplicationRequest;
use App\Http\Requests\RepairApplication\IndexRepairApplicationRequest;
use App\Http\Requests\RepairApplication\StoreRepairApplicationRequest;
use App\Http\Requests\RepairApplication\UpdateRepairApplicationRequest;
use App\Models\Equipment;
use App\Models\RepairApplication;
use App\Models\RepairApplicationStatus;
use App\Models\RepairStatus;
use App\Models\RepairType;
use App\Models\User;
use App\Notifications\RepairApplicationStatusChangedNotification;
use App\Notifications\UserAccountChangedNotification;
use App\Services\RepairApplication\StoreRepairApplicationService;
use App\Services\RepairApplication\UpdateRepairApplicationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(RepairApplication::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRepairApplicationRequest $request)
    {
        $queryParams = $request->validated();

        $repairApplications = RepairApplication::getByParams($queryParams)
            ->paginate(5)
            ->withQueryString();
        $applicationStatuses = RepairApplicationStatus::all();

        return view(
            'repair-applications.index',
            compact('repairApplications', 'applicationStatuses')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateRepairtApplicationRequest $request)
    {
        $validatedData = $request->validated();
        $chosenEquipment = Equipment::find(
            $validatedData['equipment_id'] ?? null
        );
        return view(
            'repair-applications.create',
            compact('chosenEquipment')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairApplicationRequest $request, StoreRepairApplicationService $service)
    {
        $validatedData = $request->validated();
        $processedData = $service->processData($validatedData);

        $repairApplication = RepairApplication::create($processedData);

        $service->setRepairApplication($repairApplication);
        $service->notify();

        return redirect()->route(
            'repair-applications.show',
            $repairApplication->id
        )
            ->with('status', 'repair-application-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairApplication $repairApplication)
    {
        $repairApplication->load('status', 'equipment', 'user');
        return view('repair-applications.show', compact('repairApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairApplication $repairApplication)
    {
        $repairApplication->load('status');
        $repairApplicationStatuses = RepairApplicationStatus::all();
        return view(
            'repair-applications.edit',
            compact('repairApplication', 'repairApplicationStatuses')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateRepairApplicationRequest $request,
        UpdateRepairApplicationService $service,
        RepairApplication $repairApplication
    ) {
        $validatedData = $request->validated();
        $processedData = $service->processData($validatedData);

        $repairApplication->fill($processedData)->save();

        $service->setRepairApplication($repairApplication);
        $service->notify();

        return redirect()->route(
            'repair-applications.show',
            $repairApplication->id
        )
            ->with('status', 'repair-application-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairApplication $repairApplication)
    {
        $repairApplication->delete();
        return redirect()->route('repair-applications.index')
            ->with('status', 'repair-application-deleted');
    }

    public function storeImages(
        StoreImageRequest $request,
        RepairApplication $repairApplication
    ) {
        $this->authorize('manageImages', $repairApplication);
        $files = $request->file('images');
        $repairApplication->storeMedia($files, 'images');

        return redirect()->route(
            'repair-applications.show',
            $repairApplication->id
        )
            ->with('status', 'images-stored');
    }

    /**
     * Remove the image
     */
    public function destroyImage(
        Request $request,
        RepairApplication $repairApplication
    ) {
        $this->authorize('manageImages', $repairApplication);

        $images = $repairApplication->getMedia('images');
        $imageIndex = $request->get('image_index');
        $images[$imageIndex]->delete();
        return redirect()->route(
            'repair-applications.show',
            $repairApplication->id
        )
            ->with('status', 'image-deleted');
    }
}
