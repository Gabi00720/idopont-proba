<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\Request;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions\Action as InfolistAction;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kérelmek';

    protected static ?string $label = 'Kérelem';

    protected static ?string $pluralLabel = 'Kérelmek';

    public static function canView(Model $record): bool
    {
        $user = request()->user()?->role;
        return in_array($user, ['admin', 'manager']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Felhasználó')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('license_plates')
                    ->label('Rendszám(ok)')
                    ->required(),
                Forms\Components\DateTimePicker::make('from_date')
                    ->label('Kezdés dátuma')
                    ->required(),
                Forms\Components\DateTimePicker::make('to_date')
                    ->label('Befejezés dátuma')
                    ->required(),
                Forms\Components\TextInput::make('people')
                    ->label('Dolgozók nevei')
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->label('Helyszín')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->label('Státusz')
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->label('Megjegyzés')
                    ->columnSpanFull(),
                //Forms\Components\TextInput::make('document_path')
                //    ->label('Dokumentum')
                //    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'Feldolgozás'))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Felhasználó')
                    ->sortable(),
                Tables\Columns\TextColumn::make('from_date')
                    ->label('Kezdés')
                    ->dateTime('Y. m. d. H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('to_date')
                    ->label('Befejezés')
                    ->dateTime('Y. m. d. H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Helyszín')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Státusz')
                    ->badge(),
                //Tables\Columns\TextColumn::make('document_path')
                //    ->label('Dokumentum')
                //    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y.m.d. H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Frissítve')
                    ->dateTime('Y.m.d. H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('from_date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Kezdés - tól'),
                        Forms\Components\DatePicker::make('to')
                            ->label('Kezdés - ig'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('from_date', '>=', $date))
                            ->when($data['to'], fn ($q, $date) => $q->whereDate('from_date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Kérelem adatai')
                    ->schema([
                        TextEntry::make('user.name')->label('Felhasználó'),
                        TextEntry::make('license_plates')->label('Rendszám(ok)'),
                        TextEntry::make('from_date')->label('Kezdés')->dateTime('Y.m.d H:i'),
                        TextEntry::make('to_date')->label('Befejezés')->dateTime('Y.m.d H:i'),
                        TextEntry::make('people')->label('Dolgozók nevei'),
                        TextEntry::make('location')->label('Helyszín'),
                        TextEntry::make('status')->label('Státusz'),
                        TextEntry::make('comment')->label('Megjegyzés'),
                        //TextEntry::make('document_path')->label('Dokumentum'),
                    ])
                    ->columns(2)
                    ->footerActions([

                        InfolistAction::make('accept')
                            ->label('Elfogadva')
                            ->color('success')
                            ->requiresConfirmation()
                            ->action(fn($record) => $record->update(['status' => 'Elfogadva'])),
                        InfolistAction::make('reject')
                            ->label('Elutasítva')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->action(fn($record) => $record->update(['status' => 'Elutasítva'])),
                        InfolistAction::make('close')
                            ->label('Bezárás')
                            ->color('gray')
                            ->url(fn() => static::getUrl('index'))
                    ])
                    ->footerActionsAlignment(Alignment::End),
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
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'view' => Pages\ViewRequest::route('/{record}'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
