<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CalendarIntegration extends Component
{
    public $isConnected = false;

    public function mount()
    {
        $this->isConnected = !empty(Auth::user()->google_calendar_token);
    }

    public function disconnect()
    {
        $user = Auth::user();
        $user->update([
            'google_calendar_token' => null,
            'google_calendar_refresh_token' => null,
        ]);
        
        $this->isConnected = false;
        
        // Use Livewire V3 notification if available, or just session flash
        session()->flash('message', 'Google Calendar berhasil diputus.');
    }

    public function connect()
    {
        // Redirect to Google OAuth for Calendar specifically, or general Google login if not logged in
        return redirect()->route('auth.google.calendar');
    }

    public function render()
    {
        return view('livewire.profile.calendar-integration');
    }
}
