<?php

namespace App\Filament\Resources\TabResource\Pages;

use App\Filament\Resources\TabResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTabs extends ListRecords
{
    protected static string $resource = TabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
