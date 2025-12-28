<?php

namespace App\Filament\Resources\EngagementOptionResource\Pages;

use App\Filament\Resources\EngagementOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEngagementOption extends EditRecord
{
    protected static string $resource = EngagementOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
