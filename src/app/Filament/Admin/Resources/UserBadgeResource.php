<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserBadgeResource\Pages;
use App\Filament\Admin\Resources\UserBadgeResource\RelationManagers;
use App\Models\UserBadge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserBadgeResource extends Resource
{
    protected static ?string $model = UserBadge::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserBadges::route('/'),
            'create' => Pages\CreateUserBadge::route('/create'),
            'edit' => Pages\EditUserBadge::route('/{record}/edit'),
        ];
    }
}
