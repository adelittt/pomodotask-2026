<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ChallengeResource\Pages;
use App\Filament\Admin\Resources\ChallengeResource\RelationManagers;
use App\Models\Challenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChallengeResource extends Resource
{
    protected static ?string $model = Challenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('target_hours')
                    ->numeric()
                    ->required()
                    ->default(20)
                    ->label('Target Jam'),
                Forms\Components\TextInput::make('duration_weeks')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->label('Durasi (Minggu)'),
                Forms\Components\Select::make('badge_id')
                    ->relationship('badge', 'name')
                    ->label('Hadiah Badge')
                    ->nullable()
                    ->preload(),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_hours')
                    ->label('Target Jam')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_weeks')
                    ->label('Durasi (Minggu)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('badge.name')
                    ->label('Hadiah Badge')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListChallenges::route('/'),
            'create' => Pages\CreateChallenge::route('/create'),
            'edit' => Pages\EditChallenge::route('/{record}/edit'),
        ];
    }
}
