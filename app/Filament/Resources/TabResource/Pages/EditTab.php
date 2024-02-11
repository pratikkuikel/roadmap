<?php

namespace App\Filament\Resources\TabResource\Pages;

use App\Filament\Resources\TabResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTab extends EditRecord
{
    protected static string $resource = TabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
