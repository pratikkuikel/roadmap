<?php

namespace App\Filament\Resources;

use App\Events\IssueEvent;
use App\Filament\Resources\IssueResource\Pages;
use App\Filament\Resources\IssueResource\RelationManagers\CommentsRelationManager;
use App\Models\Issue;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class IssueResource extends Resource
{
    protected static ?string $model = Issue::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount(['comments', 'votes']);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'The number of issues';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Select::make('tab_id')
                        ->relationship('tab', 'label')
                        ->required(),
                    TextInput::make('title')
                        ->required(),
                ]),
                Group::make([
                    Forms\Components\Select::make('tags')
                        ->multiple()
                        ->relationship('tags', 'label')
                        ->preload(),
                    DateTimePicker::make('target_date')
                        ->default(null)
                        ->time(false),
                ]),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('tab.label')
                    ->label('Tab'),
                Infolists\Components\TextEntry::make('title')
                    ->label('Title'),
                Infolists\Components\TextEntry::make('votes_count')
                    ->label('Total Votes'),
                Infolists\Components\TextEntry::make('upvotes_count')
                    ->label('Upvotes')
                    ->iconColor('success')
                    ->icon('heroicon-o-chevron-double-up'),
                Infolists\Components\TextEntry::make('downvotes_count')
                    ->label('Downvotes')
                    ->iconColor('danger')
                    ->icon('heroicon-o-chevron-double-down'),
                Infolists\Components\TextEntry::make('fire_count')
                    ->label('Fire')
                    ->iconColor('primary')
                    ->icon('heroicon-o-fire'),
                Infolists\Components\TextEntry::make('target_date')
                    ->date(),
                Infolists\Components\TextEntry::make('tags.label')
                    ->badge(),
                Infolists\Components\TextEntry::make('description')
                    ->html()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tab.label'),
                TextColumn::make('title')
                    ->searchable()
                    ->limit(20),
                TextColumn::make('tags.label')
                    ->searchable()
                    ->badge(),
                TextColumn::make('target_date')
                    ->date(),
                TextColumn::make('created_at')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('move_issue')
                    ->icon('heroicon-o-arrow-up-on-square-stack')
                    ->form([
                        Select::make('tab_id')
                            ->relationship('tab', 'label')
                            ->required(),
                    ])
                    ->action(function (array $data, Issue $record): void {
                        $record->tab()->associate($data['tab_id']);
                        $record->save();
                        // propagate an event here to record in timeline
                        event(new IssueEvent($record->id, "Moved to {$record->tab->label}"));
                    }),
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
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIssues::route('/'),
            'create' => Pages\CreateIssue::route('/create'),
            'edit' => Pages\EditIssue::route('/{record}/edit'),
            'view' => Pages\ViewIssue::route('/{record}/view')
        ];
    }
}
