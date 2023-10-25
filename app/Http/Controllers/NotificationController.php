<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = Notification::where('user_id', $user->id);

        if (auth()->user()->type == 'adviser') {
            return view('notify', compact(['notifications']));
        }else if (auth()->user()->type == 'teacher') {
            return view('notify', compact(['notifications']));
        }else if (auth()->user()->type == 'office') {
            return view('notify', compact(['notifications']));
        }else{
            return view('notify', compact(['notifications']));
        }
    }
}