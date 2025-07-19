<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvestigationResource\Pages;
use App\Filament\Resources\InvestigationResource\RelationManagers;
use App\Models\Investigation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Str;
use Filament\Forms\Components\Textarea;
class InvestigationResource extends Resource
{
    protected static ?string $model = Investigation::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
public static function getNavigationGroup(): ?string
        {
            return 'Settings'; // Match this to a group from navigationGroups()
        }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Name')->required()->columnSpan(2)->unique(
                                table: Investigation::class,
                                ignorable: fn ($record) => $record
                ),
                TextArea::make('description')->label('Description')->required()->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->sortable()->searchable(),
                TextColumn::make('description')->label('Description')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListInvestigations::route('/'),
            'create' => Pages\CreateInvestigation::route('/create'),
            'edit' => Pages\EditInvestigation::route('/{record}/edit'),
        ];
    }
}
