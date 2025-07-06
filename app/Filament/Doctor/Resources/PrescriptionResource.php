<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\PrescriptionResource\Pages;
use App\Filament\Doctor\Resources\PrescriptionResource\RelationManagers;
use App\Models\Prescription;
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
use App\Models\Investigavion;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use App\Models\MedicinePrescription;
use Filament\Tables\Actions\Action;
class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('doctor_id', auth()->user()->id);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    // Left column
                Section::make([
                    Hidden::make('doctor_id')->default(auth()->user()->id),
                    TextInput::make('date')
                                ->label('Date')
                                ->required()
                                ->default(now()->format('d-M-Y'))
                                ->readOnly(),

                    Repeater::make('complaint')
                        ->schema([
                            Select::make('complaint_id')
                                ->label('Complaint')
                                ->options(ChiefComplaint::pluck('name','id')->toArray())
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $complaint = ChiefComplaint::find($state);
                                    $set('complaint_name', $complaint?->name);
                                })->columnSpan('full')
                                ->searchable()
                                ->required(),
                                Hidden::make('complaint_name'),
                            ]),

                    Repeater::make('investigavion')
                        ->schema([
                            Select::make('investigavion_id')
                                ->label('Investigavion')
                                ->options(Investigavion::pluck('name','id')->toArray())
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $investigavion = Investigavion::find($state);
                                    $set('investigavion_name', $investigavion?->name);
                                })->columnSpan('full')
                                ->searchable()
                                ->required(),
                                Hidden::make('investigavion_name'),
                    ]),

                    DatePicker::make('next_visit_date')->label('Next Visit'),
                    TextInput::make('next_visit_fee')->label('Next Visit Fee')->default(0)->required(),
                    Repeater::make('advice')
                        ->schema([
                            TextInput::make('advice')->label('advice'),
                        ])->mutateDehydratedStateUsing(function ($state) {
        // Remove empty rows before saving
                        return collect($state)
                            ->filter(fn ($item) => !empty($item['advice']))
                            ->values()
                            ->all();
                    }),
                ])->grow(false)->columns(1)->columnSpan(1),


               // Right column
                Section::make([

                    Select::make('patient_id')
                                ->label('Patient Name')
                                    ->options(
                                        Patient::where('doctor_id', auth()->id())
                                            ->pluck('name', 'id')
                                            ->toArray()
                                    )
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $patient = Patient::find($state);
                                        $set('patient_age', $patient?->age);
                                        $set('patient_mobile', $patient?->mobile);
                                        $set('patient_gender', $patient?->gender);
                                        $set('patient_address', $patient?->address);
                                        $set('patient_name', $patient?->name);
                                    })
                                ->searchable()
                                ->required(),

                                Hidden::make('patient_name'),

                    TextInput::make('patient_age')
                                ->label('Patient Age')->required(),
                    TextInput::make('patient_mobile')
                                ->label('Mobile Number'),

                    TextInput::make('patient_gender')
                                ->label('Gender')->required(),
                    TextInput::make('patient_address')->label('Address')->required()->columnSpan(2),


                    Fieldset::make('Prescription')
                        ->schema([

                    Repeater::make('prescription_medicines')
                        ->schema([
                            Select::make('medicine_id')
                                ->label('Medicine')
                                ->options(Medicine::pluck('name','id')->toArray())
                                ->searchable()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                        $patient = Medicine::find($state);
                                        $set('medicine_name', $patient?->name);
                                    })
                                ->required(),
                                Hidden::make('medicine_name'),
                                Select::make('dose')
                                ->label('Dose/Use Mode:')
                                ->options([
                                    '1 x 1 x 1' => '1 x 1 x 1',
                                    '1 x 0 x 1' => '1 x 0 x 1',
                                    '1 x 1 x 0' => '1 x 1 x 0',
                                    '0 x 1 x 1' => '0 x 1 x 1',
                                    '0 x 0 x 1' => '0 x 0 x 1',
                                    '0 x 1 x 0' => '0 x 1 x 0',
                                    '1 x 0 x 0' => '1 x 0 x 0',
                                    '1 x 1 x 1 x 1' => '1 x 1 x 1 x 1',
                                    '1 x 1 x 1 x 1 x 1' => '1 x 1 x 1 x 1 x 1',
                                    '1 x 1 x 1 x 1 x 1 x 1' => '1 x 1 x 1 x 1 x 1 x 1',
                                ])->required()->searchable(),
                                Select::make('use_time')
                                ->label('Use Time')
                                ->options([
                                    'Before Meal' => 'Before Meal',
                                    'After Meal' => 'After Meal',
                                    'Before and After Meal' => 'Before and After Meal',
                                ])->required()->searchable(),
                                Select::make('duration')
                                    ->options([

                                        'custom' => 'Custom',
                                        '1 Day' => '1 Day',
                                        '2 Day' => '2 Day',
                                        '3 Day' => '3 Day',
                                        '7 Day' => '7 Day',
                                        '10 Day' => '10 Day',
                                        '14 Day' => '14 Day',
                                        '21 Day' => '21 Day',
                                        '1 Month' => '1 Month',
                                        '1.5 Month' => '1.5 Month',
                                        '2 Month' => '2 Month',
                                        '2.5 Month' => '2.5 Month',
                                        '3 Month' => '3 Month',
                                        '3.5 Month' => '3.5 Month',
                                        '4 Month' => '4 Month',
                                        '4.5 Month' => '4.5 Month',
                                        '5 Month' => '5 Month',
                                        '6 Month' => '6 Month',
                                        '8 Month' => '8 Month',
                                        '10 Month' => '10 Month',

                                    ])->reactive()->searchable(),
                                TextInput::make('custom_duration')
                                ->label('Custom Duration')
                                ->placeholder('Enter custom duration')
                                ->columnSpan('full')
                                ->hidden( function (callable $get) {
                                return $get('duration') !== 'custom';
                                }),
                     ])->columns(2)->columnSpan(2),
                    ]),
                    \Filament\Forms\Components\Group::make([
                            TextInput::make('pulse_rate')->maxLength(255)->label('Pulse Rate'),
                            TextInput::make('respiration_rate')->maxLength(255)->label('Respiration Rate'),
                            TextInput::make('bp_higher')->maxLength(255)->label('BP Higher'),
                            TextInput::make('bp_lower')->maxLength(255)->label('BP Lower'),
                            TextInput::make('temperature')->maxLength(255)->label('Temperature'),
                            Select::make('temperature_type')->options([
                                'F' => 'F°',
                                'C' => 'C°',
                            ])->default('F')->searchable(),
                            TextInput::make('weight')->maxLength(255)->label('Weight'),
                            Select::make('weight_type')->options([
                                'KG' => 'KG',
                                'LBS' => 'LBS',
                            ])->default('KG')->searchable(),
                            TextInput::make('height')->maxLength(255)->label('Height'),
                            Select::make('height_type')->options([
                                'Inch' => 'Inch',
                                'CM' => 'CM',
                            ])->default('Inch')->searchable(),
                            TextInput::make('hart_rate')->maxLength(255)->label('Hart Rate'),
                            TextInput::make('oxygen_saturation')->maxLength(255)->label('Oxygen Saturation'),
                            TextInput::make('blood_oxygen')->maxLength(255)->label('Blood Oxygen'),
                            TextInput::make('ofs')->maxLength(255)->label('OFS'),
                            TextInput::make('fhr')->maxLength(255)->label('FHR'),
                            TextInput::make('bmi')->maxLength(255)->label('BMI'),
                            TextInput::make('bsa')->maxLength(255)->label('BSA'),
                            TextInput::make('bmi_status')->maxLength(255)->label('BMI Status'),
                            DatePicker::make('lpm_date')->label('LPM Date')->columnSpan(2),


                        ])
                        ->columns(5)->columnSpan(3)
                        ->relationship('vitalSign'),
                ])->columns(3)->columnSpan(3),
            ])->from('lg'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable(),
                TextColumn::make('date')->label('Appoint Date')->sortable()->searchable(),
                TextColumn::make('patient_name')->label('Patient')->sortable()->searchable(),
                TextColumn::make('patient_mobile')->label('Mobile No')->sortable()->searchable(),
                TextColumn::make('patient_age')->label('Age')->sortable()->searchable(),
                TextColumn::make('patient_gender')->label('Gender')->sortable()->searchable(),
                TextColumn::make('next_visit_date')->label('Next Visit')->sortable()->searchable(),

                ])
            ->filters([
                 SelectFilter::make('patient_gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('view')
                ->label('View')
                ->url(fn ($record) => PrescriptionResource::getUrl('view', ['record' => $record]))
                ->icon('heroicon-o-eye'),
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
            'index' => Pages\ListPrescriptions::route('/'),
            'create' => Pages\CreatePrescription::route('/create'),
            'edit' => Pages\EditPrescription::route('/{record}/edit'),
            'view' => Pages\ViewPrescription::route('/{record}'),
        ];
    }
}
