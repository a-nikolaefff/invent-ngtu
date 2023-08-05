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
        $filter = app()->make(
            RepairApplicationFilter::class,
            ['queryParams' => $queryParams]
        );

        $repairApplications = RepairApplication::select('repair_applications.*')
            ->leftjoin(
                'equipment',
                'repair_applications.equipment_id',
                '=',
                'equipment.id'
            )
            ->leftjoin(
                'users',
                'repair_applications.user_id',
                '=',
                'users.id'
            )
            ->with('status', 'equipment', 'user')
            ->when(
                Auth::user()->hasRole(UserRoleEnum::Employee),
                function ($query) {
                    return $query->where(
                        'repair_applications.user_id',
                        Auth::user()->id
                    );
                }
            )
            ->filter($filter)
            ->sort($queryParams)
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
    public function store(StoreRepairApplicationRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['application_date'] = Carbon::now();
        $validatedData['repair_application_status_id']
            = RepairApplicationStatus::where(
            'name',
            RepairApplicationStatusEnum::Pending->value
        )->value('id');
        $validatedData['user_id'] = $request->user()->id;
        RepairApplication::create($validatedData);
        return redirect()->route('repair-applications.index')
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
        RepairApplication $repairApplication
    ) {
        $validatedData = $request->validated();

        $approvedAndRejectedStatusIds = RepairApplicationStatus::whereIn(
            'name',
            [
                RepairApplicationStatusEnum::Approved->value,
                RepairApplicationStatusEnum::Rejected->value
            ]
        )->pluck('id');
        if ($approvedAndRejectedStatusIds->contains(
            $validatedData['repair_application_status_id']
        )
        ) {
            $validatedData['response_date'] = Carbon::now();
        } else {
            $validatedData['response_date'] = null;
        }

        $repairApplication->fill($validatedData)->save();
        return redirect()->route(
            'repair-applications.show',
            $repairApplication->id
        )
            ->with('status', 'repair-updated');
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
        $this->authorize('view', $repairApplication);
        $files = $request->file('images');

        foreach ($files as $file) {
            $repairApplication->addMedia($file)
                ->withCustomProperties([
                    'user_id' => Auth::user()->id,
                    'user_name' => Auth::user()->name,
                    'datetime' => Carbon::now()->format('d.m.Y H:i:s')
                ])
                ->toMediaCollection('images');
        }

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
        $this->authorize('view', $repairApplication);

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
