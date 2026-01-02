<?php

namespace App\Filament\Resources\AlumnusResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ConsentRelationManager extends RelationManager
{
    protected static string $relationship = 'consent';
    protected static ?string $title = 'Consent';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Consent')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('consent_type')
                        ->label('Consent Type')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\Toggle::make('is_agreed')
                        ->label('Agreed')
                        ->default(true),

                    Forms\Components\DateTimePicker::make('agreed_at')
                        ->label('Agreed At')
                        ->seconds(false),

                    Forms\Components\TextInput::make('ip_address')
                        ->label('IP Address')
                        ->maxLength(100),

                    Forms\Components\Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3)
                        ->columnSpan(2),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('consent_type')
            ->columns([
                Tables\Columns\TextColumn::make('consent_type')->label('Type')->searchable(),
                Tables\Columns\IconColumn::make('is_agreed')->label('Agreed')->boolean(),
                Tables\Columns\TextColumn::make('agreed_at')->label('Agreed At')->dateTime('M d, Y h:i A')->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn () => $this->getOwnerRecord()?->consent === null),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
