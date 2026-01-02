<?php

namespace App\Filament\Resources\AlumnusResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EmploymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'employments';
    protected static ?string $title = 'Employments';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Employment Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('position')
                        ->label('Position')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('company')
                        ->label('Company / Organization')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\Select::make('org_type')
                        ->label('Organization Type')
                        ->options([
                            'government'   => 'Government',
                            'private'      => 'Private',
                            'ngo'          => 'NGO',
                            'academe'      => 'Academe',
                            'self-employed'=> 'Self-employed',
                        ])
                        ->native(false),

                    Forms\Components\DatePicker::make('start_date')
                        ->label('Start Date'),

                    Forms\Components\Textarea::make('office_address')
                        ->label('Office Address')
                        ->rows(3)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('office_contact')
                        ->label('Office Contact')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('office_email')
                        ->label('Office Email')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('licenses')
                        ->label('Licenses / Certifications')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('achievements')
                        ->label('Achievements')
                        ->maxLength(255)
                        ->columnSpan(2),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('position')
            ->columns([
                Tables\Columns\TextColumn::make('position')
                    ->label('Position')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('company')
                    ->label('Company')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('org_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'government' => 'Government',
                        'private' => 'Private',
                        'ngo' => 'NGO',
                        'academe' => 'Academe',
                        'self-employed' => 'Self-employed',
                        default => $state ?: '—',
                    }),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('M d, Y')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('office_email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('office_contact')
                    ->label('Contact')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_date', 'desc')
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
