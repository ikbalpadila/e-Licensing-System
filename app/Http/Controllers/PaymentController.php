<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, $applicationId)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'provider' => 'nullable|string'
        ]);

        $validated['permit_application_id'] = $applicationId;
        $validated['transaction_id'] = strtoupper('TX-' . uniqid());
        $validated['status'] = 'success';
        $validated['paid_at'] = now();

        $payment = Payment::create($validated);

        return response()->json($payment, 201);
    }

    public function show($applicationId)
    {
        $payment = Payment::where('permit_application_id', $applicationId)->first();
        return response()->json($payment);
    }
}
