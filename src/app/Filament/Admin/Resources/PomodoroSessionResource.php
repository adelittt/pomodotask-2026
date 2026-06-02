<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PomodoroSessionResource\Pages;
use App\Filament\Admin\Resources\PomodoroSessionResource\RelationManagers;
use App\Models\PomodoroSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PomodoroSessionResource extends Resource
{
    protected static ?string $model = PomodoroSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),
                Forms\Components\Select::make('task_id')
                    ->relationship('task', 'title')
                    ->disabled(),
                Forms\Components\TextInput::make('duration')
                    ->numeric()
                    ->disabled(),
                Forms\Components\TextInput::make('type')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('completed_at')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('task.title')
                    ->label('Tugas')
                    ->searchable()
                    ->sortable()
                    ->default('-')
                    ->limit(40),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi (Menit)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'work' => 'danger',
                        'short_break' => 'success',
                        'long_break' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPomodoroSessions::route('/'),
        ];
    }
}
