<?php

namespace App\Filament\Admin\Resources\UserBadgeResource\Pages;

use App\Filament\Admin\Resources\UserBadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserBadges extends ListRecords
{
    protected static string $resource = UserBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
