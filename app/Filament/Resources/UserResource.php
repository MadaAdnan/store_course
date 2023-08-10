<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('المستخدمين')->schema([
                    Forms\Components\TextInput::make('name')->label('الاسم')->required(),
                    Forms\Components\TextInput::make('email')->label('البريد الإلكتروني')->email()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('password')->label('كلمة المرور')->required(fn($context)=>$context=='create')->minLength(8)
                        ->password()->dehydrated(fn($state)=>filled($state)),
                    Forms\Components\Radio::make('status')->options([
                        'pending' => 'بإنتظار الموافقة',
                        'active' => 'مفعل',
                        'inactive' => 'محظور',
                    ])->label('حالة المستخدم')->default('pending')->required()->inline(),
                    Forms\Components\Select::make('level')->options([
                        'store' => 'متجر',
                        'admin' => 'مدير',
                        'user' => 'مستخدم',
                    ])->label('رتبة المستخدم')->default('user')->reactive(),
                    Forms\Components\Fieldset::make('بيانات المتجر')->schema([
                        Forms\Components\TextInput::make('address')->label('العنوان')->required(),
                        Forms\Components\TextInput::make('phone')->label('رقم الهاتف')->required(),
                        Forms\Components\TextInput::make('store_name')->label('اسم المتجر')->required(),
                    ])->visible(fn($get) => $get('level') == 'store')

                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإضافة')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('الاسم'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
