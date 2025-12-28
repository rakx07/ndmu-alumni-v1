<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StrandResource\Pages;
use App\Models\Strand;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StrandResource extends Resource
{
    protected static ?string $model = Strand::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationLabel = 'SHS Strands';
    protected static ?string $navigationGroup = 'Reference Data';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Strand Name')
                ->required()
                ->maxLength(100)
                ->unique(ignoreRecord: true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Strand')
                    ->searchable()
                    ->sortable(),
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
            'index'  => Pages\ListStrands::route('/'),
            'create' => Pages\CreateStrand::route('/create'),
            'edit'   => Pages\EditStrand::route('/{record}/edit'),
        ];
    }
}
