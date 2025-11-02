<?php

namespace App\Http\Controllers;

use App\Models\Verification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function store(Request $request, $applicationId)
    {
        $request->validate([
            'remarks' => 'nullable|string',
            'is_verified' => 'required|boolean'
        ]);

        $verification = Verification::create([
            'permit_application_id' => $applicationId,
            'officer_id' => auth()->id(),
            'remarks' => $request->remarks,
            'is_verified' => $request->is_verified,
            'verified_at' => now(),
        ]);

        return response()->json($verification, 201);
    }
}
