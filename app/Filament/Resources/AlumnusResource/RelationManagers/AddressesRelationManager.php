<?php

namespace App\Filament\Resources\AlumnusResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $title = 'Addresses';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Address Details')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('type')
                        ->label('Address Type')
                        ->options([
                            'home'      => 'Home',
                            'permanent' => 'Permanent',
                            'current'   => 'Current',
                            'office'    => 'Office',
                        ])
                        ->required()
                        ->native(false)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('line1')
                        ->label('Line 1')
                        ->maxLength(255)
                        ->required()
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('line2')
                        ->label('Line 2')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('city')
                        ->label('City')
                        ->maxLength(255)
                        ->required(),

                    Forms\Components\TextInput::make('province')
                        ->label('Province')
                        ->maxLength(255)
                        ->required(),

                    Forms\Components\TextInput::make('country')
                        ->label('Country')
                        ->maxLength(255)
                        ->default('Philippines')
                        ->required(),

                    Forms\Components\TextInput::make('postal_code')
                        ->label('Postal Code')
                        ->maxLength(20),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('line1')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('line1')
                    ->label('Line 1')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->sortable(),

                Tables\Columns\TextColumn::make('province')
                    ->label('Province')
                    ->sortable(),

                Tables\Columns\TextColumn::make('country')
                    ->label('Country'),

                Tables\Columns\TextColumn::make('postal_code')
                    ->label('Postal Code'),
            ])
            ->defaultSort('type') // ✅ VALID column
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
