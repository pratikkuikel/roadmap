<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TabResource\Pages;
use App\Models\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TabResource extends Resource
{
    protected static ?string $model = Tab::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('issues');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label'),
                TextColumn::make('issues_count')
                    ->label('Issues'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTabs::route('/'),
            'create' => Pages\CreateTab::route('/create'),
            'edit' => Pages\EditTab::route('/{record}/edit'),
        ];
    }
}
