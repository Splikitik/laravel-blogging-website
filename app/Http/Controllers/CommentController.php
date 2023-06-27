<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class CommentController extends Controller
{
    public function store (Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|int',
            'blog_id' => 'required|int',
        ]);

        $request->user()->comments()->create($validated);

        return redirect()->back()->with('response', 'Comment-posted');
    }

    public function edit(Request $request, Comment $comment) : View
    {
        $message = Comment::where('id', $request->id)->get();
        return view('comments.edit', [
            'comments' => $comment,
            'id' => $request->id,
            'message' => $message['0']['message'],
        ]);
    }

    public function update(Request $request) : RedirectResponse
    {

        
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // dd($request->message);
        // dd($validated);
        $comment = Comment::where('id', $request->id);
        $blog_id = $comment->where([
            'id' => $request->id,
        ])->get('blog_id');

        $blog_id = $blog_id->toArray();
        $blog_id = $blog_id['0']['blog_id'];
        $chirp = Chirp::where('id', $blog_id);
        $comment->where([
            'id' => $request->id,
        ])->update([
            'message' => $request->message,
        ]);

        return to_route('chirps.view', ['chirp' => $blog_id]);
    }

    public function destroy(Request $request)
    {

        $comment = Comment::where('id', $request->id);
        $comment->delete();

        return redirect()->back();
    }
}
