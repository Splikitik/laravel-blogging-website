<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Request as ModelsRequest;
use Symfony\Component\Console\Input\Input;
use Illuminate\Database\Eloquent\Collection;

class ChirpController extends Controller
{

    

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if(auth()->user()->role == 'admin')
        {
            return view('chirps.home', [
                'chirps' => Chirp::with('user')->latest()->get(),
            ]);
        }

        if(auth()->user()->role == 'user')
        {
            return view('chirps.home', [
                'chirps' => Chirp::with('user')->where([
                    'status' => 'Accepted',
                ])->latest()->get(),
            ]);
        }
    }

    public function indexSearch(Request $request): View
    {
        if(auth()->user()->role == 'admin')
        {
            return view('chirps.home', [
                'chirps' => Chirp::with('user')->where([
                    'description' => $request->title,
                ])->latest()->get(),
            ]);
        }

        if(auth()->user()->role == 'user')
        {
            return view('chirps.home', [
                'chirps' => Chirp::with('user')->where([
                    'status' => 'Accepted',
                    'description' => $request->title,
                ])->latest()->get(),
            ]);
        }
    }

    public function myBlogs(): View
    {
        $id = auth()->user()->id;
        
        $chirps = Chirp::with('user')->where('user_id', $id)->latest()->get();
        $comments = Comment::all();
        
        return view('chirps.myBlogs', [
            'chirps' => $chirps,
            'comments' => $comments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('chirps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        // dd($request);
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'image',
            'status' => 'required',
        ]);

        $path = $request->file('image')->store('blog-image', 'public');
        $validated['image'] = "storage/".$path;
        // dd($validated['image']);

        // //
        // $path = $request->file('avatar')->store('avatars', 'public');
        // auth()->user()->update(['avatar' => "storage/".$path]);
        // return redirect(route('profile.edit'))->with('status', 'avatar-updated'); 
        // // 

        $request->user()->chirps()->create($validated);
        $request_id = Chirp::latest()->max('id');

        $request->user()->requests()->create([
            'blog_id' => $request_id,
            'request_type' => 'Blog Post',
            'request_status' => 'Pending',
            'status' => 'Pending',
        ]);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('chirps.home', [
            'chirps' => Chirp::with('user')->latest()->get('id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp) : View
    {
        $this->authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ])->with('status', 'chirp-updated');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp) : RedirectResponse
    {
        $this->authorize('update', $chirp);

        $id = $chirp->id;
        $validated = $request->validate([
            'message' => 'required|string|',
            'description' => 'required|string',

        ]);

        $chirp->update($validated);

        return to_route('chirps.view', ['chirp' => $id]);
    }

    public function statusUpdate(Request $request) : RedirectResponse
    {
        $chirp = Chirp::find($request->chirp_id);
        $request_id = $request->chirp_id;
        $status = $request->status;
        $chirp->where([
            'id' => $request_id,
        ])->update([
            'status' => $status,
        ]);


        $request_id = $request->chirp_id;
        $request_query = ModelsRequest::where('blog_id', $request->chirp_id);

        $request_query->where([
            'blog_id' => $request_id,
        ])->update([
            'request_status' => $status,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {

        $chirp->delete();

        return redirect(route('chirps.index'));
    }

    public function view(string $request) : View
    {
        $id = $request;
        $blog = Chirp::where('id', $id)->get();
        $comments = Comment::where('blog_id', $id)->get();
        // dd($comments);
        return view('chirps.view', [
            'chirps' => $blog,
            'comments' => $comments,
        ]);
    }
}
