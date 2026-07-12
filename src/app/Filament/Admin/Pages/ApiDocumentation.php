<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class ApiDocumentation extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Settings';
    protected static string $view = 'filament.admin.pages.api-documentation';
}
