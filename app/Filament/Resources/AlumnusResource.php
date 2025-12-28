<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnusResource\Pages;
use App\Models\Alumnus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;  
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AlumnusResource extends Resource
{
    protected static ?string $model = Alumnus::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Alumni Records';
    protected static ?string $navigationGroup = 'Directory';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Personal Information')
                ->columns(3)
                ->schema([
                    Select::make('track')
                        ->label('Track')
                        ->options([
                            'college' => 'College',
                            'grad_law' => 'Graduate / Law',
                            'elementary' => 'Elementary',
                            'jhs_shs' => 'Junior / Senior High School',
                        ])
                        ->required()
                        ->native(false),

                    TextInput::make('full_name')
                        ->label('Full Name')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),

                    TextInput::make('nickname')
                        ->label('Nickname')
                        ->maxLength(255),

                    Select::make('sex')
                        ->label('Sex')
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                            'Prefer not to say' => 'Prefer not to say',
                        ])
                        ->native(false),

                    DatePicker::make('date_of_birth')
                        ->label('Date of Birth'),

                    Select::make('civil_status')
                        ->label('Civil Status')
                        ->options([
                            'Single' => 'Single',
                            'Married' => 'Married',
                            'Widowed' => 'Widowed',
                            'Separated' => 'Separated',
                        ])
                        ->native(false),

                    TextInput::make('nationality')
                        ->label('Nationality')
                        ->maxLength(255),

                    TextInput::make('religion')
                        ->label('Religion')
                        ->maxLength(255),

                    TextInput::make('student_number')
                        ->label('Student Number (if known)')
                        ->maxLength(100),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('track')
                    ->label('Track')
                    ->sortable(),

                TextColumn::make('student_number')
                    ->label('Student #')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('track')
                    ->label('Track')
                    ->options([
                        'college' => 'College',
                        'grad_law' => 'Graduate / Law',
                        'elementary' => 'Elementary',
                        'jhs_shs' => 'Junior / Senior High School',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add RelationManagers here later (Profile, Addresses, Educations, Employments, etc.)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAlumni::route('/'),
            'create' => Pages\CreateAlumnus::route('/create'),
            'edit'   => Pages\EditAlumnus::route('/{record}/edit'),
        ];
    }
}
