<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\ChamberResource\Pages;
use App\Filament\Doctor\Resources\ChamberResource\RelationManagers;
use App\Models\Chamber;
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
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Toggle;
use App\Models\Patient;
use App\Models\ChiefComplaint;
use App\Models\Medicine;
use App\Models\Investigation;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use App\Models\MedicinePrescription;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\ActionGroup;
class ChamberResource extends Resource
{
    protected static ?string $model = Chamber::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
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
                TextInput::make('name')
                    ->label('Chamber Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->label('Address')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Phone')
                    ->nullable()
                    ->maxLength(20),
                TextInput::make('email')
                    ->label('Email')
                    ->nullable()
                    ->email()
                    ->maxLength(255),
                TextInput::make('website')
                    ->label('Website')
                    ->nullable()
                    ->url()
                    ->maxLength(255),
                TimePicker::make('opening_time')
                    ->label('Opening Time')
                    ->nullable(),
                TimePicker::make('closing_time')
                    ->label('Closing Time')
                    ->nullable(),
                    Hidden::make('doctor_id')
                    ->default(auth()->user()->id),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Chamber Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone')
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
            'index' => Pages\ListChambers::route('/'),
            'create' => Pages\CreateChamber::route('/create'),
            'edit' => Pages\EditChamber::route('/{record}/edit'),
        ];
    }
}
