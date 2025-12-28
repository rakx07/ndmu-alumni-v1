<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EngagementOptionResource\Pages;
use App\Models\EngagementOption;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EngagementOptionResource extends Resource
{
    protected static ?string $model = EngagementOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Engagement Options';
    protected static ?string $navigationGroup = 'Reference Data';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('code')
                ->label('Code')
                ->helperText('Unique key used internally (e.g., events, mentor, networking, talks, donate, email_updates).')
                ->required()
                ->maxLength(100)
                ->unique(ignoreRecord: true)
                ->rule('alpha_dash'),

            TextInput::make('label')
                ->label('Label')
                ->helperText('Text shown to alumni as a checkbox option.')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->wrap(),
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
            'index'  => Pages\ListEngagementOptions::route('/'),
            'create' => Pages\CreateEngagementOption::route('/create'),
            'edit'   => Pages\EditEngagementOption::route('/{record}/edit'),
        ];
    }
}
