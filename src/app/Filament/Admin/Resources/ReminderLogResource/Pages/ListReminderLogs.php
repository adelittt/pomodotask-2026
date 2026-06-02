<?php

namespace App\Filament\Admin\Resources\ReminderLogResource\Pages;

use App\Filament\Admin\Resources\ReminderLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReminderLogs extends ListRecords
{
    protected static string $resource = ReminderLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
