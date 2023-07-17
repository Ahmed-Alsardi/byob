<?php

namespace App\Features\Complaint;

use App\Events\OrderUpdate;
use App\Http\Requests\UpdateComplaintRequest;
use App\Models\Complaint;
use App\Repository\ComplaintRepository;
use Illuminate\Http\Request;

class ComplaintViewHandler
{

    public function handleList(Request $request) {
        $userId = $request->user()->id;
        $userRole = $request->user()->role;
        $complaints = ComplaintRepository::getComplaintsByUserId($userId, $userRole);
        return view("complaints", [
            "complaints" => $complaints
        ]);
    }

    public function handleShow(Request $request, Complaint $complaint)
    {
        return view("complaint", [
            "complaint" => $complaint
        ]);
    }

    public function handleUpdate(UpdateComplaintRequest $request, Complaint $complaint)
    {
        $validated = $request->validated();
        $userId = $request->user()->id;
        ComplaintRepository::resolveComplaint($complaint, $validated['refund'], $validated['admin_message'], $userId);
        OrderUpdate::dispatch($request->user());
        return redirect()->route("complaint.index");
    }
}
