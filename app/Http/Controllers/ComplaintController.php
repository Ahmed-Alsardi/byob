<?php

namespace App\Http\Controllers;

use App\Features\Complaint\ComplaintViewHandler;
use App\Http\Requests\UpdateComplaintRequest;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ComplaintViewHandler $handler)
    {
        $this->authorize("view-list-complaint");
        return $handler->handleList($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Complaint $complaint, ComplaintViewHandler $handler)
    {
        $this->authorize("view-complaint", $complaint);
        return $handler->handleShow($request, $complaint);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint, ComplaintViewHandler $handler)
    {
        $this->authorize("update-complaint", $complaint);
        return $handler->handleUpdate($request, $complaint);
    }
}
