<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function store(Request $request, $applicationId)
    {
        $request->validate([
            'is_approved' => 'required|boolean',
            'remarks' => 'nullable|string'
        ]);

        $approval = Approval::create([
            'permit_application_id' => $applicationId,
            'supervisor_id' => auth()->id(),
            'is_approved' => $request->is_approved,
            'remarks' => $request->remarks,
            'approved_at' => now()
        ]);

        return response()->json($approval, 201);
    }
}
