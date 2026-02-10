<?php

namespace App\Http\Controllers;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
       public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('center', compact('announcements'));
    }
}
