<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnusResource\Pages;
use App\Models\Alumnus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
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

    /**
     * ✅ This powers the ViewAction page.
     * Update the field names here to match your actual columns/relations.
     */
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make('Personal Information')
                ->columns(3)
                ->schema([
                    TextEntry::make('full_name')->label('Full Name')->copyable(),
                    TextEntry::make('nickname')->label('Nickname')->placeholder('—'),
                    TextEntry::make('track')
                        ->label('Track')
                        ->formatStateUsing(fn (?string $state) => match ($state) {
                            'college' => 'College',
                            'grad_law' => 'Graduate / Law',
                            'elementary' => 'Elementary',
                            'jhs_shs' => 'Junior / Senior High School',
                            default => $state ?: '—',
                        }),

                    TextEntry::make('sex')->label('Sex')->placeholder('—'),
                    TextEntry::make('civil_status')->label('Civil Status')->placeholder('—'),
                    TextEntry::make('date_of_birth')->label('Date of Birth')->date('M d, Y')->placeholder('—'),

                    TextEntry::make('nationality')->label('Nationality')->placeholder('—'),
                    TextEntry::make('religion')->label('Religion')->placeholder('—'),
                    TextEntry::make('student_number')->label('Student #')->placeholder('—')->copyable(),
                ]),

            // ✅ If you have these relations, this will show them.
            // If your relation names differ, tell me your model relations and I'll adjust quickly.

            InfoSection::make('Contact / Profile')
                ->columns(3)
                ->schema([
                    TextEntry::make('profile.contact_number')->label('Contact Number')->placeholder('—')->copyable(),
                    TextEntry::make('profile.email')->label('Email')->placeholder('—')->copyable(),
                    TextEntry::make('profile.facebook_handle')->label('Facebook / Handle')->placeholder('—')->copyable(),
                ])
                ->collapsed(),

            InfoSection::make('Addresses')
                ->schema([
                    Grid::make(2)->schema([
                        InfoSection::make('Permanent Address')
                            ->schema([
                                TextEntry::make('permanentAddress.line1')->label('Line 1')->placeholder('—'),
                                TextEntry::make('permanentAddress.line2')->label('Line 2')->placeholder('—'),
                                TextEntry::make('permanentAddress.city')->label('City')->placeholder('—'),
                                TextEntry::make('permanentAddress.province')->label('Province')->placeholder('—'),
                                TextEntry::make('permanentAddress.country')->label('Country')->placeholder('—'),
                                TextEntry::make('permanentAddress.postal_code')->label('Postal Code')->placeholder('—'),
                            ])
                            ->columns(2),

                        InfoSection::make('Current Address')
                            ->schema([
                                TextEntry::make('currentAddress.line1')->label('Line 1')->placeholder('—'),
                                TextEntry::make('currentAddress.line2')->label('Line 2')->placeholder('—'),
                                TextEntry::make('currentAddress.city')->label('City')->placeholder('—'),
                                TextEntry::make('currentAddress.province')->label('Province')->placeholder('—'),
                                TextEntry::make('currentAddress.country')->label('Country')->placeholder('—'),
                                TextEntry::make('currentAddress.postal_code')->label('Postal Code')->placeholder('—'),
                            ])
                            ->columns(2),
                    ]),
                ])
                ->collapsed(),

            InfoSection::make('Employment')
                ->columns(3)
                ->schema([
                    TextEntry::make('employment.position')->label('Position')->placeholder('—'),
                    TextEntry::make('employment.company')->label('Company')->placeholder('—'),
                    TextEntry::make('employment.org_type')->label('Organization Type')->placeholder('—'),

                    TextEntry::make('employment.start_date')->label('Start Date')->date('M d, Y')->placeholder('—'),
                    TextEntry::make('employment.office_contact')->label('Office Contact')->placeholder('—'),
                    TextEntry::make('employment.office_email')->label('Office Email')->placeholder('—'),

                    TextEntry::make('employment.office_address')->label('Office Address')->placeholder('—')->columnSpanFull(),
                    TextEntry::make('employment.licenses')->label('Licenses / Certifications')->placeholder('—')->columnSpanFull(),
                    TextEntry::make('employment.achievements')->label('Achievements')->placeholder('—')->columnSpanFull(),
                ])
                ->collapsed(),

            InfoSection::make('Timestamps')
                ->columns(2)
                ->schema([
                    TextEntry::make('created_at')->label('Created')->dateTime('M d, Y h:i A'),
                    TextEntry::make('updated_at')->label('Last Updated')->dateTime('M d, Y h:i A'),
                ])
                ->collapsed(),
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
        \App\Filament\Resources\AlumnusResource\RelationManagers\ProfileRelationManager::class,
        \App\Filament\Resources\AlumnusResource\RelationManagers\AddressesRelationManager::class,
        \App\Filament\Resources\AlumnusResource\RelationManagers\EducationsRelationManager::class,
        \App\Filament\Resources\AlumnusResource\RelationManagers\EmploymentsRelationManager::class,
        \App\Filament\Resources\AlumnusResource\RelationManagers\CommunityInvolvementsRelationManager::class,
        \App\Filament\Resources\AlumnusResource\RelationManagers\ConsentRelationManager::class,
    ];
}


    public static function getPages(): array
{
    return [
        'index'  => Pages\ListAlumni::route('/'),
        'create' => Pages\CreateAlumnus::route('/create'),
        'view'   => Pages\ViewAlumnus::route('/{record}'),
        'edit'   => Pages\EditAlumnus::route('/{record}/edit'),
    ];
}

}
