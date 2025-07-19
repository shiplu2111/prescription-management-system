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
use App\Models\Chamber;
use App\Models\Investigation;
use App\Models\Advice;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use App\Models\MedicinePrescription;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
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
                    Select::make('chamber_id')
                                ->label('Chamber Name')
                                ->options(
                                    Chamber::where('doctor_id', auth()->user()->id)
                                        ->pluck('name', 'id')
                                        ->toArray()
                                )
                                ->searchable()
                                ->required(),
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

                    Repeater::make('investigation')
                        ->schema([
                            Select::make('investigation_id')
                                ->label('Investigation')
                                ->options(Investigation::pluck('name','id')->toArray())
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $investigation = Investigation::find($state);
                                    $set('investigation_name', $investigation?->name);
                                })->columnSpan('full')
                                ->searchable(),
                                Hidden::make('investigation_name'),
                    ]),

                    DatePicker::make('next_visit_date')->label('Next Visit'),
                    TextInput::make('next_visit_fee')->label('Next Visit Fee')->default(0),

                ])->grow(false)->columns(1)->columnSpan(1),


               // Right column
                Section::make([
                    Fieldset::make('Patient Details')
                        ->schema([
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
                                ->searchable(),

                                TextInput::make('patient_name')->label('Patient Name')->required(),

                    TextInput::make('patient_age')
                                ->label('Patient Age')->required(),
                    TextInput::make('patient_mobile')
                                ->label('Mobile Number'),

                    TextInput::make('patient_gender')
                                ->label('Gender')->required(),
                    TextInput::make('patient_address')->label('Address')->required(),

                ]),
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
                                    '১ x ১ x ১' => '১ x ১ x ১',
                                    '১ x 0 x ১' => '১ x 0 x ১',
                                    '১ x ১ x 0' => '১ x ১ x 0',
                                    '0 x ১ x ১' => '0 x ১ x ১',
                                    '0 x 0 x ১' => '0 x 0 x ১',
                                    '0 x ১ x 0' => '0 x ১ x 0',
                                    '১ x 0 x 0' => '১ x 0 x 0',
                                    '১ x ১ x ১ x ১' => '১ x ১ x ১ x ১',
                                    '১ x ১ x ১ x ১ x ১' => '১ x ১ x ১ x ১ x ১',
                                    '১ x ১ x ১ x ১ x ১ x ১' => '১ x ১ x ১ x ১ x ১ x ১',
                                ])->required()->searchable(),
                                Select::make('use_time')
                                ->label('Use Time')
                                ->options([
                                    'খাবারের আগে' => 'খাবারের আগে',
                                    'খাবারের আগে এবং পরে' => 'খাবারের আগে এবং পরে',
                                    'খাবারের আগে এবং সাথে' => 'খাবারের আগে এবং সাথে',
                                    'খাবারের সাথে' => 'খাবারের সাথে',
                                    'খাবারের সাথে এবং পরে' => 'খাবারের সাথে এবং পরে',
                                    'খাবারের পরে' => 'খাবারের পরে',
                                ])->required()->searchable(),
                                Select::make('duration')
                                    ->options([

                                        '১ দিন' => '১ দিন',
                                        '২ দিন' => '২ দিন',
                                        '৩ দিন' => '৩ দিন',
                                        '৭ দিন' => '৭ দিন',
                                        '১০ দিন' => '১০ দিন',
                                        '১৪ দিন' => '১৪ দিন',
                                        '২১ দিন' => '২১ দিন',
                                        '১ মাস' => '১ মাস',
                                        '১.৫ মাস' => '১.৫ মাস',
                                        '২ মাস' => '২ মাস',
                                        '২.৫ মাস' => '২.৫ মাস',
                                        '৩ মাস' => '৩ মাস',
                                        '৩.৫ মাস' => '৩.৫ মাস',
                                        '৪ মাস' => '৪ মাস',
                                        '৪.৫ মাস' => '৪.৫ মাস',
                                        '৫ মাস' => '৫ মাস',
                                        '৬ মাস' => '৬ মাস',
                                        '৮ মাস' => '৮ মাস',
                                        '১০ মাস' => '১০ মাস',

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

                    Fieldset::make('Patient Advices')
                        ->schema([
                        Repeater::make('advice')
                     ->schema([
                            Select::make('advice_id')
                                ->label('Advice')
                                ->options(Advice::pluck('title','id')->toArray())
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $advice = Advice::find($state);
                                    $set('advice_name', $advice?->title);
                                })->columnSpan('full')
                                ->searchable(),
                                Hidden::make('advice_name'),
                    ])->mutateDehydratedStateUsing(function ($state) {
        // Remove empty rows before saving
                        return collect($state)
                            ->filter(fn ($item) => !empty($item['advice']))
                            ->values()
                            ->all();
                    })->columnSpan(3),
                ]),
                    Fieldset::make('Vital Signs')
                        ->schema([
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
                ]),

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
                Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),
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
