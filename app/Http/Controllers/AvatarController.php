<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request) : RedirectResponse
    {
        $path = $request->file('avatar')->store('avatars', 'public');
        auth()->user()->update(['avatar' => "storage/".$path]);
        return redirect(route('profile.edit'))->with('status', 'avatar-updated');
    }
}

// ->update(['avatar'=>'test'])