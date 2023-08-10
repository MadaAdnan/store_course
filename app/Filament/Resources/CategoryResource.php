<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('الأقسام')->schema([
                    Forms\Components\Select::make('user_id')->options(fn() => User::where('level', 'store')->pluck('store_name', 'id'))->label('اختر المتجر')->searchable()->required(),
                    Forms\Components\TextInput::make('name')->label('اسم القسم')->required(),

                ])
                 ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('name')->label('اسم القسم')->searchable(isIndividual: true),
               Tables\Columns\TextColumn::make('user.store_name')->label('اسم المتجر')->searchable(isIndividual: true),
               Tables\Columns\TextColumn::make('products_count')->label('اسم المتجر')->label('عدد المنتجات')
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')->options(fn() => User::where('level', 'store')->pluck('store_name', 'id'))->label('اختر المتجر')->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
