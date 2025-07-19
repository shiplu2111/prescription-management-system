<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\ProfileResource\Pages;
use App\Filament\Doctor\Resources\ProfileResource\RelationManagers;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone')
                    ->label('Phone')
                    ->maxLength(15),
                TextInput::make('university')
                    ->label('University')
                    ->maxLength(255),
                TextInput::make('degree')
                    ->label('Degree')
                    ->maxLength(255),
                // TextInput::make('specialization')
                //     ->label('Specialization')
                //     ->maxLength(255),
                TextInput::make('experience')
                    ->label('Experience')
                    ->maxLength(255),
                TextInput::make('designation')
                    ->label('Designation')
                    ->maxLength(255),
                TextInput::make('institution')
                    ->label('Institution')
                    ->maxLength(255),
                Hidden::make('user_id')->default(auth()->user()->id),
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
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
