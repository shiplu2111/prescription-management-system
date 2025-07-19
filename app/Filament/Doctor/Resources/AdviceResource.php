<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\AdviceResource\Pages;
use App\Filament\Doctor\Resources\AdviceResource\RelationManagers;
use App\Models\Advice;
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
use Filament\Tables\Actions\ActionGroup;

class AdviceResource extends Resource
{
    protected static ?string $model = Advice::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';
 public static function getNavigationGroup(): ?string
        {
            return 'Settings'; // Match this to a group from navigationGroups()
        }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('doctor_id', auth()->user()->id);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),
                // Textarea::make('description')
                //     ->label('Description')
                //     ->required()->columnSpanFull()
                //     ->maxLength(65535),
                Hidden::make('doctor_id')
                    ->default(auth()->user()->id),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('description')
                //     ->label('Description')
                //     ->searchable()
                //     ->limit(50),
                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),

                ]),
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
            'index' => Pages\ListAdvice::route('/'),
            'create' => Pages\CreateAdvice::route('/create'),
            'edit' => Pages\EditAdvice::route('/{record}/edit'),
        ];
    }
}
