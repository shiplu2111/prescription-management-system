<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\PatientResource\Pages;
use App\Filament\Doctor\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
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
class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
        {
            return 'Patients'; // Match this to a group from navigationGroups()
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
                 Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                          ->schema([

                                Hidden::make('doctor_id')->default(auth()->user()->id),

                            Select::make('patient_type')
                            ->label('Patient Type')
                            ->options([
                                'general' => 'General',
                                'doctor' => 'Doctor',
                                'corporate' => 'Corporate',
                                'stuff' => 'Stuff',
                                'student' => 'Student',
                                'other' => 'Other',
                            ])
                            ->required(),
                            TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Surname, Firstname, Middlename')
                            ->required(),
                            TextInput::make('mobile')
                            ->label('Mobile Number')
                            ->placeholder('+8801XXXXXXXXX')
                            ->required(),
                            Select::make('gender')
                            ->label('Gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ])->required(),
                            Textarea::make('address')
                            ->label('Address')
                            ->rows(3),
                            FileUpload::make('image')->label('Image')->image()->imageEditor(),


                            DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $dob = \Carbon\Carbon::parse($state);
                                    $now = \Carbon\Carbon::now();

                                    $diff = $dob->diff($now);

                                    $years = $diff->y;
                                    $months = $diff->m;
                                    $days = $diff->d;

                                    $ageString = "{$years} years";
                                    if ($months > 0) {
                                        $ageString .= ", {$months} months";
                                    }
                                    if ($days > 0) {
                                        $ageString .= ", {$days} days";
                                    }

                                    $set('age', $ageString);
                                } else {
                                    $set('age', null);
                                }
                            }),

                            TextInput::make('age')->label('Age')->required()->readOnly(),
                            ToggleButtons::make('status')
                            ->label('Publication Status')
                            ->boolean()
                            ->inline()
                            ->options([
                                '1' => 'Active',
                                '0' => 'Inactive',
                            ])
                            ->required()
                            ->colors([
                                '1' => 'info',
                                '0' => 'danger',
                            ])
                            ->default('1')
                            ->grouped(),
                        ])->columns(2),


                        Tabs\Tab::make('Personal Information')
                            ->schema([
                             TextInput::make('weight')
                            ->label('Weight')
                            ->maxLength(255),
                            TextInput::make('height')
                            ->label('Height')
                            ->maxLength(255),
                            Select::make('blood_group')
                            ->label('Blood Group')
                            ->options([
                                'A+' => 'A+',
                                'A-' => 'A-',
                                'B+' => 'B+',
                                'B-' => 'B-',
                                'O+' => 'O+',
                                'O-' => 'O-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                            ]),
                            TextInput::make('id_type')
                            ->label('ID Type')
                            ->maxLength(255),
                            TextInput::make('id_number')
                            ->label('ID Number')
                            ->maxLength(255),
                        ])->columns(2),


                        Tabs\Tab::make('Others Information')
                            ->schema([
                            TextInput::make('guardian_name')
                            ->label('Guardian Name')
                            ->maxLength(255),
                            TextInput::make('guardian_number')
                            ->label('Guardian Number')
                            ->maxLength(255),
                            TextInput::make('guardian_relation')
                            ->label('Guardian Relation')
                            ->maxLength(255),
                            TextInput::make('guardian_email')
                            ->label('Guardian Email')
                            ->maxLength(255),

                            Select::make('marital_status')
                            ->label('Marital Status')
                            ->options([
                                'single' => 'Single',
                                'married' => 'Married',
                                'divorced' => 'Divorced',
                                'widowed' => 'Widowed',
                                'other' => 'Other',
                            ])
                            ->reactive()
                            ->searchable(),

                            TextInput::make('spouse_name')
                            ->label('Spouse Name')
                            ->maxLength(255)
                            ->hidden( function (callable $get) {
                                return $get('marital_status') !== 'married';
                            }),

                            TextInput::make('spouse_number')
                            ->label('Spouse Mobile Number')
                            ->maxLength(255)
                            ->hidden( function (callable $get) {
                                return $get('marital_status') !== 'married';
                            }),

                            TextInput::make('spouse_email')
                            ->label('Spouse Email')
                            ->maxLength(255)
                            ->hidden( function (callable $get) {
                                return $get('marital_status') !== 'married';
                            }),

                            TextInput::make('contact_person')
                            ->label('Contact Person')
                            ->maxLength(255),

                            TextInput::make('contact_person_number')
                            ->label('Emergency Contact Number')
                            ->maxLength(255),

                            Select::make('contact_person_relation')
                            ->label('Relation')
                            ->options([
                                'Mother' => 'Mother',
                                'Father' => 'Father',
                                'Guardian' => 'Guardian',
                                'Spouse' => 'Spouse',
                                'Grandfather' => 'Grandfather',
                                'Nephew' => 'Nephew',
                                'Niece' => 'Niece',
                                'Other' => 'Other',
                            ])
                            ->searchable(),

                            TextInput::make('contact_person_email')
                            ->label('Emergency Contact Email')
                            ->maxLength(255),

                    ])->columns(2),
                       ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Reg Date')->sortable()->searchable(),
                TextColumn::make('patient_type')->label('Type')->sortable()->searchable(),
                TextColumn::make('gender')->label('Gender')->sortable()->searchable(),
                // TextColumn::make('age')->label('Age')->sortable()->searchable(),
                TextColumn::make('blood_group')->label('Blood Group')->sortable()->searchable(),
                TextColumn::make('mobile')->label('Mobile')->sortable()->searchable(),
                CheckboxColumn::make('status')->label('Status')->sortable()->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
