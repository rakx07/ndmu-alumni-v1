<?php

namespace App\Filament\Resources\AlumnusResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CommunityInvolvementsRelationManager extends RelationManager
{
    protected static string $relationship = 'communityInvolvements';
    protected static ?string $title = 'Community Involvements';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Community Involvement')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('organization_name')
                        ->label('Organization / Association')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('role')
                        ->label('Role / Position')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('years_active')
                        ->label('Years Active')
                        ->maxLength(100),

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
            ->recordTitleAttribute('organization_name')
            ->columns([
                Tables\Columns\TextColumn::make('organization_name')
                    ->label('Organization')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('years_active')
                    ->label('Years')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
