<?php

namespace App\Filament\Resources;

use App\Enums\Country;
use App\Enums\Locale;
use App\Enums\Timezone;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->fullname;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Email' => $record->email,
            'Phone' => $record->phone,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['fullname', 'email', 'phone'];
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group';
    }

    public static function getNavigationLabel(): string
    {
        return __('Users');
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('firstname')
                    ->label(__('Firstname')),
                TextInput::make('lastname')
                    ->label(__('Lastname')),
                TextInput::make('email')
                    ->label(__('Email')),
                TextInput::make('phone')
                    ->label(__('Phone')),
                Select::make('country')
                    ->label(__('Country'))
                    ->options(Country::list())
                    ->native(false)
                    ->searchable(),
                Select::make('locale')
                    ->label(__('Country'))
                    ->options(Locale::list())
                    ->native(false)
                    ->searchable(),
                Select::make('timezone')
                    ->label(__('Timezone'))
                    ->options(Timezone::list())
                    ->native(false)
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname')
                    ->label(__('Fullname'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('verified')
                    ->label(__('Verified'))
                    ->getStateUsing(function (Model $record) {
                        return $record->isVerified() ? __('Yes') : __('No');
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        __('Yes') => 'success',
                        __('No') => 'danger',
                    }),
                TextColumn::make('onboarded')
                    ->label(__('Onboarded'))
                    ->getStateUsing(function (Model $record) {
                        return $record->isOnboarded() ? __('Yes') : __('No');
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        __('Yes') => 'success',
                        __('No') => 'danger',
                    }),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
