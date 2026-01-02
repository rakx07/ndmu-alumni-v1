<?php

namespace App\Filament\Resources\AlumnusResource\Pages;

use App\Filament\Resources\AlumnusResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewAlumnus extends ViewRecord
{
    protected static string $resource = AlumnusResource::class;

    protected function resolveRecord($key): Model
    {
        /** @var Model $record */
        $record = parent::resolveRecord($key);

        return $record->loadMissing([
            'profile',
            'addresses',
            'educations',
            'employments',
            'communityInvolvements',
            'consent',
        ]);
    }
}
