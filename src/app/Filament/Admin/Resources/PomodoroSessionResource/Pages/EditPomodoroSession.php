<?php

namespace App\Filament\Admin\Resources\PomodoroSessionResource\Pages;

use App\Filament\Admin\Resources\PomodoroSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPomodoroSession extends EditRecord
{
    protected static string $resource = PomodoroSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
