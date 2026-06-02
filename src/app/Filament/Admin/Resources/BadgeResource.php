<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BadgeResource\Pages;
use App\Filament\Admin\Resources\BadgeResource\RelationManagers;
use App\Models\Badge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BadgeResource extends Resource
{
    protected static ?string $model = Badge::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('icon')
                    ->options([
                        'heroicon-o-academic-cap' => 'Academic Cap 🎓',
                        'heroicon-o-trophy' => 'Trophy 🏆',
                        'heroicon-o-fire' => 'Fire 🔥',
                        'heroicon-o-sparkles' => 'Sparkles ✨',
                        'heroicon-o-clock' => 'Clock ⏰',
                        'heroicon-o-check-circle' => 'Check Circle Checkmark ✅',
                    ])
                    ->default('heroicon-o-academic-cap')
                    ->required(),
                Forms\Components\Select::make('rule_type')
                    ->options([
                        'pomodoro_count' => 'Jumlah Sesi Pomodoro Selesai',
                        'task_completed' => 'Jumlah Tugas Selesai',
                        'challenge_completed' => 'Jumlah Tantangan Diikuti & Selesai',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('rule_value')
                    ->numeric()
                    ->required()
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon')
                    ->label('Icon Name'),
                Tables\Columns\TextColumn::make('rule_type')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rule_value')
                    ->label('Target Nilai')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBadges::route('/'),
            'create' => Pages\CreateBadge::route('/create'),
            'edit' => Pages\EditBadge::route('/{record}/edit'),
        ];
    }
}
