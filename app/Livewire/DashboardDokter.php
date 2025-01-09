<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;

class DashboardDokter extends Component
{
    public function render()
    {
        $users = User::with(['unreadMessages'])
            ->where('id', '!=', Auth::id()) // Exclude logged-in user
            ->where('id_role', '!=', 5) // exclude admin
            ->get();

        $sessions = Message::with('isEnded')
        ->whereHas('isEnded', function ($query) {
            $query->where('to_user_id', Auth::id());
        })->get();
        // dd($sessions->toArray());

        // $sessions = Message::with(['isEnded'])->get();


        return view('livewire.dashboard-dokter', compact('users', 'sessions'));
    }
}
