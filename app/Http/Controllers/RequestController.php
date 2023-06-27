<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Request as ModelsRequest;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.index', [
            'requests' => ModelsRequest::with('user')->latest()->get(),
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
    public function store(Request $request) : RedirectResponse
    {
        $request->user()->requests()->create([
            'request_type' => 'Blog Post',
            'request_status' => 'Pending',
        ]);

        return redirect(route('admin.dashboard'))->with('message', 'Request Stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        // $this->authorize('update', $chirp);

        // return view('chirps.edit', [
        //     'chirp' => $chirp,
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTest(Request $request, Chirp $chirp) : RedirectResponse
    {
        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $request_id = $request->request_id;

        $delete_request = ModelsRequest::find($request_id);

        $delete_request->delete();

        return redirect(route('admin.dashboard'));
    }

    public function accept(Request $request) : RedirectResponse
    {
        $request_id = $request->request_id;
        $request_query = ModelsRequest::find($request->request_id);
        // $request_id = $request->request_id;
    
        $request_query->where([
            'id' => $request_id,
        ])->update([
            'request_status' => 'Accepted',
        ]);

        $blog_query = Chirp::find($request->request_id);
        $blog_query->where([
            'id' => $request_id,
        ])->update([
            'status' => 'Accepted',
        ]);

        return redirect(route('admin.requests'))->with('message', 'Request Accepted');
    }

    public function reject(Request $request) : RedirectResponse
    {
        $request_id = $request->request_id;
        $request_query = ModelsRequest::find($request->request_id);
        // $request_id = $request->request_id;

        $request_query->where([
            'id' => $request_id,
        ])->update([
            'request_status' => 'Rejected',
        ]);

        $blog_query = Chirp::find($request->request_id);
        $blog_query->where([
            'id' => $request_id,
        ])->update([
            'status' => 'Rejected',
        ]);

        return redirect(route('admin.dashboard'))->with('message', 'Request Rejected');
    }
}
