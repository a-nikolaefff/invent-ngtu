<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomType\IndexRoomTypeRequest;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Http\Requests\RoomType\UpdateRoomTypeRequest;
use App\Models\BuildingType;
use App\Models\RoomType;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin-panel');
    }
}
