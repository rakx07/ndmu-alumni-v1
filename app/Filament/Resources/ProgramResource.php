<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Programs';
    protected static ?string $navigationGroup = 'Reference Data';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('college_id')
                ->label('College')
                ->relationship('college', 'name')
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('name')
                ->label('Program Name')
                ->required()
                ->maxLength(255),

            Select::make('level')
                ->label('Level')
                ->options([
                    'college' => 'College',
                    'grad' => 'Graduate School',
                    'law' => 'Law School',
                ])
                ->native(false)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Program')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('college.name')
                    ->label('College')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('level')
                    ->label('Level')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('level')->options([
                    'college' => 'College',
                    'grad' => 'Graduate',
                    'law' => 'Law',
                ]),
                SelectFilter::make('college_id')
                    ->label('College')
                    ->relationship('college', 'name'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
