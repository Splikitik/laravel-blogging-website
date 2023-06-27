<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Chirp;
use App\Models\Request as ModelsRequest;
use App\Models\User;

class BlogController extends Controller
{

    public function adminshow(): View
    {
        $userCount = User::count();
        $chirpCount = Chirp::count();
        $requestCount = ModelsRequest::count();
        $pendingCount = ModelsRequest::where('request_status', 'Pending')->count();
        $chirpCount = (Chirp::count()) - $pendingCount;
        return view('admin.dashboard', [
            'chirps' => Chirp::with('user')->latest()->get(),
            'users' => User::all(),
            'requests' => ModelsRequest::all(),
            'chirpCount' => $chirpCount,
            'userCount' => $userCount,
            'requestCount' => $requestCount,
            'pendingCount' => $pendingCount,
        ]);
    }

    public function requestShow(): View
    {
        $userCount = User::count();
        $pendingCount = ModelsRequest::where('request_status', 'Pending')->count();
        $chirpCount = (Chirp::count()) - $pendingCount;
        
        $requestCount = ModelsRequest::count();
        $pendingRequests = ModelsRequest::where('request_status', 'Pending')->get();
        return view('admin.dashboard.requests', [
            'chirps' => Chirp::with('user')->latest()->get(),
            'users' => User::all(),
            'requests' => ModelsRequest::all(),
            'chirpCount' => $chirpCount,
            'userCount' => $userCount,
            'requestCount' => $requestCount,
            'pendingCount' => $pendingCount,
            'pendingRequests' => $pendingRequests,
        ]);
    }

    public function blogShow(): View
    {
        $pendingCount = ModelsRequest::where('request_status', 'Pending')->count();
        $chirpCount = (Chirp::count()) - $pendingCount;
        $rejectedCount = Chirp::where('status', 'Rejected')->count();
        $acceptedCount = Chirp::where('status', 'Accepted')->count();
        $chirpAccepted = Chirp::where('status', 'Accepted')->get();
        $chirpRejected = Chirp::where('status', 'Rejected')->get();
        return view('admin.dashboard.blogs', [
            'chirps' => Chirp::with('user')->latest()->get(),
            'chirpAccepted' => $chirpAccepted,
            'chirpRejected' => $chirpRejected,
            'rejectedCount' => $rejectedCount,
            'acceptedCount' => $acceptedCount,
            'chirpCount' => $chirpCount,
        ]);
    }

    public function pendingShow(): View
    {
        $pending = ModelsRequest::where('request_status', 'Pending')->count();
        return view('admin.dashboard.pending', [
            'pendingCount' => $pending,
        ]);
    }

    public function userShow(): View
    {
        $userCount = User::count();
        return view('admin.dashboard.users', [
            'users' => User::all(),
            'userCount' => $userCount,
        ]);
    }
}
