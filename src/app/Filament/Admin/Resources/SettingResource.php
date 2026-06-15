<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SettingResource\Pages;
use App\Filament\Admin\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?string $navigationGroup = 'Sistem';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Kunci Pengaturan')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled(fn (?Setting $record) => $record !== null), // disable edit key
                
                Forms\Components\Select::make('value')
                    ->label('Nilai Pengaturan (Ringtone)')
                    ->options([
                        'default' => 'Beep Default (Sistem)',
                        'ringtone1.mp3' => 'Digital Alarm',
                        'ringtone2.mp3' => 'Soft Bell',
                        'ringtone3.mp3' => 'Marimba',
                    ])
                    ->required()
                    ->visible(fn (Forms\Get $get) => $get('key') === 'pomodoro_ringtone'),

                Forms\Components\Textarea::make('value')
                    ->label('Nilai Pengaturan')
                    ->required()
                    ->hidden(fn (Forms\Get $get) => $get('key') === 'pomodoro_ringtone'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->label('Kunci')->searchable(),
                Tables\Columns\TextColumn::make('value')->label('Nilai')->limit(50),
                Tables\Columns\TextColumn::make('updated_at')->label('Terakhir Diubah')->dateTime(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
