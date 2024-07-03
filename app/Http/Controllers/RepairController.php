<?php

namespace App\Http\Controllers;

use App\Http\Requests\Images\StoreImageRequest;
use App\Http\Requests\Repair\CreateRepairtRequest;
use App\Http\Requests\Repair\IndexRepairRequest;
use App\Http\Requests\Repair\StoreRepairRequest;
use App\Http\Requests\Repair\UpdateRepairRequest;
use App\Models\Equipment;
use App\Models\Repair;
use App\Models\RepairStatus;
use App\Models\RepairType;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Repair::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRepairRequest $request)
    {
        $queryParams = $request->validated();

        $repairs = Repair::getByParams($queryParams)
            ->paginate(5)
            ->withQueryString();
        $repairTypes = RepairType::all();
        $repairStatuses = RepairStatus::all();

        return view(
            'repairs.index',
            compact(
                'repairs',
                'repairTypes',
                'repairStatuses',
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateRepairtRequest $request)
    {
        $validatedData = $request->validated();
        $chosenEquipment = Equipment::find(
            $validatedData['equipment_id'] ?? null
        );
        $repairTypes = RepairType::all();
        $repairStatuses = RepairStatus::all();

        return view(
            'repairs.create',
            compact('chosenEquipment', 'repairTypes', 'repairStatuses')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairRequest $request)
    {
        $validatedData = $request->validated();
        $repair = Repair::create($validatedData);

        return redirect()->route('repairs.show', $repair->id)
            ->with('status', 'repair-stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(Repair $repair)
    {
        $repair->load('type', 'status', 'equipment');

        return view('repairs.show', compact('repair'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repair $repair)
    {
        $repair->load('type', 'status', 'equipment');
        $repairTypes = RepairType::all();
        $repairStatuses = RepairStatus::all();

        return view(
            'repairs.edit',
            compact('repair', 'repairTypes', 'repairStatuses')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairRequest $request, Repair $repair)
    {
        $validatedData = $request->validated();
        $repair->fill($validatedData)->save();

        return redirect()->route('repairs.show', $repair->id)
            ->with('status', 'repair-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repair $repair)
    {
        $repair->delete();

        return redirect()->route('repairs.index')
            ->with('status', 'repair-deleted');
    }

    /**
     * Store a new image before the repair.
     */
    public function storeBeforeImages(
        StoreImageRequest $request,
        Repair $repair
    ) {
        $this->authorize('update', $repair);
        $files = $request->file('images');
        $repair->storeMedia($files, 'before');

        return redirect()->route('repairs.show', $repair->id)
            ->with('status', 'images-stored');
    }

    /**
     * Store a new image before the repair.
     */
    public function storeAfterImages(
        StoreImageRequest $request,
        Repair $repair
    ) {
        $this->authorize('update', $repair);
        $files = $request->file('images');
        $repair->storeMedia($files, 'after');

        return redirect()->route('repairs.show', $repair->id)
            ->with('status', 'images-stored');
    }

    /**
     * Remove the image before the repair
     */
    public function destroyBeforeImage(Request $request, Repair $repair)
    {
        $this->authorize('manageImages', $repair);

        $images = $repair->getMedia('before');
        $imageIndex = $request->get('image_index');
        $images[$imageIndex]->delete();

        return redirect()->route('repairs.show', $repair->id)
            ->with('status', 'image-deleted');
    }

    /**
     * Remove the image after the repair
     */
    public function destroyAfterImage(Request $request, Repair $repair)
    {
        $this->authorize('manageImages', $repair);

        $images = $repair->getMedia('after');
        $imageIndex = $request->get('image_index');
        $images[$imageIndex]->delete();

        return redirect()->route('repairs.show', $repair->id)
            ->with('status', 'image-deleted');
    }
}
