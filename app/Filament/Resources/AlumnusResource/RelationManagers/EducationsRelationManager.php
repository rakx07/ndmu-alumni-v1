<?php

namespace App\Filament\Resources\AlumnusResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EducationsRelationManager extends RelationManager
{
    protected static string $relationship = 'educations';
    protected static ?string $title = 'Educations';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Education Details')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('context')
                        ->label('Education Context')
                        ->options([
                            'ndmu_college'  => 'NDMU College',
                            'ndmu_grad_law' => 'NDMU Graduate / Law',
                            'ndmu_elem'     => 'NDMU Elementary',
                            'ndmu_jhs'      => 'NDMU Junior High',
                            'ndmu_shs'      => 'NDMU Senior High',
                            'post_ndmu'     => 'Post-NDMU',
                            'continuing'    => 'Continuing',
                        ])
                        ->native(false)
                        ->required()
                        ->columnSpan(2),

                    // ✅ These rely on Education model relations: college(), program(), strand()
                    Forms\Components\Select::make('college_id')
                        ->label('College')
                        ->relationship('college', 'name')
                        ->searchable()
                        ->preload()
                        ->native(false),

                    Forms\Components\Select::make('program_id')
                        ->label('Program / Degree')
                        ->relationship('program', 'name')
                        ->searchable()
                        ->preload()
                        ->native(false),

                    Forms\Components\Select::make('strand_id')
                        ->label('Strand (SHS)')
                        ->relationship('strand', 'name')
                        ->searchable()
                        ->preload()
                        ->native(false),

                    // Optional text fields (still in your table)
                    Forms\Components\TextInput::make('level_label')
                        ->label('Degree / Level / Program (text)')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('institution_name')
                        ->label('Institution / School')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('institution_location')
                        ->label('Institution Location')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('year_entered')
                        ->label('Year Entered')
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue((int) date('Y')),

                    Forms\Components\TextInput::make('year_graduated')
                        ->label('Year Graduated / Last Year Attended')
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue((int) date('Y') + 5),

                    Forms\Components\TextInput::make('thesis_title')
                        ->label('Thesis / Capstone Title')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('honors')
                        ->label('Honors / Awards')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\Textarea::make('remarks')
                        ->label('Remarks')
                        ->rows(3)
                        ->columnSpan(2),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('institution_name')
            ->columns([
                // ✅ Program name from relation, fallback to level_label
                Tables\Columns\TextColumn::make('program.name')
                    ->label('Degree / Program')
                    ->state(fn ($record) => $record->program->name ?? $record->level_label ?? '—')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('institution_name')
                    ->label('Institution')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('year_entered')
                    ->label('Entered')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('year_graduated')
                    ->label('Graduated')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('college.name')
                    ->label('College')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap(),

                Tables\Columns\TextColumn::make('strand.name')
                    ->label('Strand')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('context')
                    ->label('Context')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('degree_program')
                    ->label('Degree / Program')
                    ->searchable()
                    ->wrap(),
            ])
            ->defaultSort('year_entered', 'desc')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
