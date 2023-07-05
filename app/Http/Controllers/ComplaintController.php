<?php

namespace App\Http\Controllers;

use App\Helper\UserRole;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Models\Complaint;
use App\Repository\ComplaintRepository;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === UserRole::CUSTOMER) {
            $complaints = ComplaintRepository::getComplaintsByUser(auth()->user());
        } else if (auth()->user()->role === UserRole::ADMIN){
            $complaints = ComplaintRepository::getAll();
        } else {
            return redirect()->route("home");
        }
        return view("complaints", [
            "complaints" => $complaints
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        return view("complaint", [
            "complaint" => $complaint
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}
