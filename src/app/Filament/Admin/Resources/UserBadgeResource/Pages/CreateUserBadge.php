<?php

namespace App\Filament\Admin\Resources\UserBadgeResource\Pages;

use App\Filament\Admin\Resources\UserBadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserBadge extends CreateRecord
{
    protected static string $resource = UserBadgeResource::class;
}
