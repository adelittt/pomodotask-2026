<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Badge;

class UserBadgeList extends Component
{
    public function render()
    {
        $userId = auth()->id();
        $badges = Badge::all();
        $earnedBadgeIds = auth()->user()->badges()->pluck('badges.id')->toArray();

        return view('livewire.user-badge-list', compact('badges', 'earnedBadgeIds'));
    }
}
