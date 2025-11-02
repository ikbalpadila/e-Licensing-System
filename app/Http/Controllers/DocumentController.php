<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index($applicationId)
    {
        return Document::where('permit_application_id', $applicationId)->get();
    }

    public function store(Request $request, $applicationId)
    {
        $request->validate([
            'file' => 'required|file|max:2048'
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        $document = Document::create([
            'permit_application_id' => $applicationId,
            'name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'size_kb' => round($file->getSize() / 1024),
        ]);

        return response()->json($document, 201);
    }

    public function destroy($id)
    {
        $doc = Document::findOrFail($id);
        Storage::disk('public')->delete($doc->file_path);
        $doc->delete();

        return response()->json(['deleted' => true]);
    }
}
