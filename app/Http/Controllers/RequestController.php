<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'license_plates' => 'required|array',
            'from_date' => 'required',
            'to_date' => 'required|after_or_equal:from_date',
            'people' => 'required|array',
            'location' => 'required|string|max:255',
            'status' => 'in:Elutasítva,Feldolgozás,Elfogadva',
            'comment' => 'nullable|string',
            'document' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
            $validated['document_path'] = $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Feldolgozás';

        Request::create($validated);

        return back()->with('success', 'Kérelem sikeresen mentve.');
    }

    public function index()
    {
        return \App\Http\Resources\RequestResource::collection(
            Request::with('user')->latest()->get()
        );
    }
}
