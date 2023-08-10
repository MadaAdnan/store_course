<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    // ->dehydrateStateUsing(fn($state) => \Hash::make($state))->dehydrated(fn($state) => filled($state))
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المنتجات')->schema([
                    Forms\Components\Select::make('user_id')->options(fn()=>User::where('level','store')->pluck('store_name','id'))->label('اختر المتجر')->searchable()->required()->reactive(),
                    Forms\Components\Select::make('category_id')->options(fn($get)=>Category::where('user_id',$get('user_id'))->pluck('name','id'))->label('اختر القسم')->required(),
                    Forms\Components\TextInput::make('name')->label('اسم المنتج')->required(),
                    Forms\Components\Textarea::make('info')->label('ةصف المنتج'),
                    Forms\Components\Select::make('status')->options([
                        'available'=>'مفعل',
                        'unavailable'=>'غير متوفر',
                        'inactive'=>'محظور',
                    ])->required(),
                    Forms\Components\TextInput::make('price')->label('السعر')->required()->numeric()->step(0.5)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
            Tables\Columns\TextColumn::make('name')->label('اسم المنتج')->searchable(),
            Tables\Columns\TextColumn::make('price')->label('سعر المنتج'),
            Tables\Columns\TextColumn::make('user.store_name')->label('المتجر'),
            Tables\Columns\TextColumn::make('category.name')->label('القسم'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')->relationship('category','name')->label('ابحث بالقسم')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
