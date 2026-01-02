<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnusResource\Pages;
use App\Filament\Resources\AlumnusResource\RelationManagers\AddressesRelationManager;
use App\Filament\Resources\AlumnusResource\RelationManagers\CommunityInvolvementsRelationManager;
use App\Filament\Resources\AlumnusResource\RelationManagers\ConsentRelationManager;
use App\Filament\Resources\AlumnusResource\RelationManagers\EducationsRelationManager;
use App\Filament\Resources\AlumnusResource\RelationManagers\EmploymentsRelationManager;
use App\Filament\Resources\AlumnusResource\RelationManagers\ProfileRelationManager;
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
     * ✅ Filament "View" page content
     * - Reads Permanent/Current from addresses(type)
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

            InfoSection::make('Contact / Profile')
                ->columns(3)
                ->schema([
                    TextEntry::make('profile.contact_number')->label('Contact Number')->placeholder('—')->copyable(),
                    TextEntry::make('profile.email')->label('Email')->placeholder('—')->copyable(),
                    TextEntry::make('profile.facebook_handle')->label('Facebook / Handle')->placeholder('—')->copyable(),
                ])
                ->collapsed(),

            /**
             * ✅ Addresses (reads from addresses relationship + type enum)
             */
            InfoSection::make('Addresses')
                ->schema([
                    Grid::make(2)->schema([
                        InfoSection::make('Permanent Address')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('perm_line1')->label('Line 1')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'permanent'))->line1 ?? '—'),
                                TextEntry::make('perm_line2')->label('Line 2')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'permanent'))->line2 ?? '—'),
                                TextEntry::make('perm_city')->label('City')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'permanent'))->city ?? '—'),
                                TextEntry::make('perm_province')->label('Province')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'permanent'))->province ?? '—'),
                                TextEntry::make('perm_country')->label('Country')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'permanent'))->country ?? '—'),
                                TextEntry::make('perm_postal')->label('Postal Code')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'permanent'))->postal_code ?? '—'),
                            ]),

                        InfoSection::make('Current Address')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('cur_line1')->label('Line 1')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'current'))->line1 ?? '—'),
                                TextEntry::make('cur_line2')->label('Line 2')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'current'))->line2 ?? '—'),
                                TextEntry::make('cur_city')->label('City')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'current'))->city ?? '—'),
                                TextEntry::make('cur_province')->label('Province')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'current'))->province ?? '—'),
                                TextEntry::make('cur_country')->label('Country')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'current'))->country ?? '—'),
                                TextEntry::make('cur_postal')->label('Postal Code')
                                    ->state(fn ($record) => optional($record->addresses->firstWhere('type', 'current'))->postal_code ?? '—'),
                            ]),
                    ]),
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
        // ✅ You already have these files in your screenshot
        return [
            ProfileRelationManager::class,
            AddressesRelationManager::class,
            EducationsRelationManager::class,
            EmploymentsRelationManager::class,
            CommunityInvolvementsRelationManager::class,
            ConsentRelationManager::class,
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
