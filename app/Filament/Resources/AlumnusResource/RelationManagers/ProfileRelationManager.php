<?php

namespace App\Filament\Resources\AlumnusResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'profile';
    protected static ?string $title = 'Profile';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Profile')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('contact_number')
                        ->label('Contact Number')
                        ->maxLength(50),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('facebook_handle')
                        ->label('Facebook / Handle')
                        ->maxLength(255)
                        ->columnSpan(2),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                Tables\Columns\TextColumn::make('contact_number')->label('Contact')->toggleable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('facebook_handle')->label('Handle')->toggleable()->wrap(),
            ])
            ->headerActions([
                // usually profile is one row only
                Tables\Actions\CreateAction::make()
                    ->visible(fn () => $this->getOwnerRecord()?->profile === null),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
