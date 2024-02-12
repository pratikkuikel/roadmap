<?php

namespace App\Filament\Resources\IssueResource\Pages;

use App\Filament\Resources\IssueResource;
use App\Models\Tab;
use Filament\Actions;
use Filament\Resources\Components\Tab as FilamentTab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListIssues extends ListRecords
{
    protected static string $resource = IssueResource::class;

    public function getTabs(): array
    {
        $tabs = ['all' => FilamentTab::make()];
        foreach (Tab::all() as $tab) {
            $tabs[$tab->label] = FilamentTab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('tab_id', $tab->id));
        }

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
