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
            Forms\Components\Section::make('Employment')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('position')
                        ->label('Position')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('company')
                        ->label('Company / Organization')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Forms\Components\Select::make('org_type')
                        ->label('Organization Type')
                        ->options([
                            'Government' => 'Government',
                            'Private' => 'Private',
                            'NGO' => 'NGO',
                            'Academe' => 'Academe',
                            'Self-employed' => 'Self-employed',
                            'Business Owner' => 'Business Owner',
                            'Student' => 'Student',
                            'Others' => 'Others',
                        ])
                        ->native(false),

                    Forms\Components\DatePicker::make('start_date')
                        ->label('Start Date'),

                    Forms\Components\TextInput::make('office_contact')
                        ->label('Office Contact')
                        ->maxLength(100),

                    Forms\Components\TextInput::make('office_email')
                        ->label('Office Email')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('office_address')
                        ->label('Office Address')
                        ->rows(3)
                        ->columnSpan(2),

                    Forms\Components\Textarea::make('licenses')
                        ->label('Licenses / Certifications')
                        ->rows(3)
                        ->columnSpan(2),

                    Forms\Components\Textarea::make('achievements')
                        ->label('Achievements')
                        ->rows(3)
                        ->columnSpan(2),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('position')
            ->columns([
                Tables\Columns\TextColumn::make('position')->label('Position')->searchable()->wrap(),
                Tables\Columns\TextColumn::make('company')->label('Company')->toggleable()->wrap(),
                Tables\Columns\TextColumn::make('org_type')->label('Type')->toggleable(),
                Tables\Columns\TextColumn::make('start_date')->label('Start')->date('M d, Y')->toggleable(),
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
