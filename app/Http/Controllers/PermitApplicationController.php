<?php

namespace App\Http\Controllers;

use App\Services\PermitApplicationService;
use Illuminate\Http\Request;

class PermitApplicationController extends Controller
{
    protected PermitApplicationService $service;

    public function __construct(PermitApplicationService $service)
    {
        // $this->middleware('auth:sanctum');
        $this->service = $service;
    }

    // 📜 List all permits (for admin/officer)
    public function index()
    {
        $permits = $this->service->getPermitsByStatus('approved');
        return response()->json($permits);
    }

    // 👤 Citizen creates new permit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'permit_type_id' => 'required|exists:permit_types,id',
            'purpose' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'total_fee' => 'required|numeric'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['application_number'] = strtoupper('APP-' . uniqid());

        $permit = $this->service->createPermit($validated);
        return response()->json($permit, 201);
    }

    // 📄 Show single permit
    public function show($id)
    {
        $permit = $this->service->repository->findById($id);
        return response()->json($permit);
    }

    // ✏️ Update permit
    public function update(Request $request, $id)
    {
        $permit = $this->service->updatePermit($id, $request->all());
        return response()->json($permit);
    }

    // ❌ Delete permit
    public function destroy($id)
    {
        $deleted = $this->service->deletePermit($id);
        return response()->json(['deleted' => $deleted]);
    }
}
