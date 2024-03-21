<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Livewire\Component;
use Filament\Forms\Components\Card;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Forms\Components\Actions\Action;

use Filament\Forms\Set;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Component as Livewire;


class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    private static $loggedInUserId;

    protected static ?string $label = 'Cliente';



    public static function form(Form $form): Form
    {
    
        $loggedInUserId = Auth::id();

        

       

        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Hidden::make('user_id') 
                            ->default($loggedInUserId),
                        Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('nome')
                                    ->required() 
                                    ->maxLength(255)
                                    ->dehydrateStateUsing(fn ($state) => ucwords($state))
                                    ->columnSpan(['md' => 5]),
                            ])->columns(['md' => 5]),
                        Card::make()
                            ->schema([
                                Repeater::make('telefones')
                                    ->relationship()
                                    ->schema([
        
                                        Forms\Components\TextInput::make('numero')
                                        ->label('Número')
                                        ->required()
                                        ->mask(RawJs::make(<<<'JS'
                                        $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                        JS))
                                        ->columnSpan(['md' => 10]),
                                    ])
                                    ->defaultItems(0)
                                    ->columns(['md' => 10]),

                            ]),
                        Card::make()
                        ->schema([
                            Repeater::make('emails')
                                ->relationship()
                                ->schema([
                                    TextInput::make('email')
                                    ->email()
                                    ->required(),
                                ])
                                ->defaultItems(0)
                                ->columnSpan('full')

                        ]),
                        Card::make()
                        ->schema([
                            Repeater::make('enderecos')
                                ->relationship()
                                ->label('Endereços')
                                ->schema([
                                    Cep::make('codigoPostal')
                                    ->label('CEP')
        
                                    
                                    ->mask('99999-999')
                                    ->columnSpan(['md' => 3])
                                    ->nullable()
                                    ->viaCep(
                                        mode: 'suffix', 
                                        errorMessage: 'CEP inválido.', 
                                        setFields: [
                                            'rua' => 'logradouro',
                                            'numero' => 'numero',
                                            'complemento' => 'complemento',
                                            'bairro' => 'bairro',
                                            'cidade' => 'localidade',
                                            'estado' => 'uf'
                                        ]
                                    ),

                                    TextInput::make('rua')
                                        ->dehydrateStateUsing(fn ($state) => ucwords($state))
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpan(['md' => 3]),

                                    TextInput::make('numero')
                                        ->required()
                                        ->label('Número')
                                        ->maxLength(6)
                                        ->columnSpan(['md' => 2]),

                                    TextInput::make('complemento')
                                        ->dehydrateStateUsing(fn ($state) => ucwords($state))
                                        ->columnSpan(['md' => 2]),
                                    
                                    TextInput::make('bairro')
                                        ->dehydrateStateUsing(fn ($state) => ucwords($state))
                                        ->columnSpan(['md' => 4]),
         
                                    TextInput::make('cidade')
                                    ->dehydrateStateUsing(fn ($state) => ucwords($state))
                                    ->label('Cidade') 
                
                                    ->required()
                                    ->columnSpan(['md' => 4]),
                                        
                                    TextInput::make('estado')
                                        ->dehydrateStateUsing(fn ($state) => ucwords($state))
               
                                        ->maxLength(255)
                                        ->columnSpan(['md' => 2]),
                                ])
                                ->defaultItems(0)
                                ->columns(['md' => 10]),

                        ]),
                    ])->columnSpan(span: 'full')
            ]);
    }

    public static function table(Table $table): Table
    {

        $loggedInUserId = Auth::id(); 

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($loggedInUserId) {
                $query->where('user_id', $loggedInUserId);
            })

            

            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable()
                    ->limit(20)
                    ->sortable(),
                Tables\Columns\TextColumn::make('telefones.numero')
                    ->label('Telefones')
                    ->searchable()
                    
                    ->limit(17)
                    ->toggleable(isToggledHiddenByDefault: False),
                
                Tables\Columns\TextColumn::make('emails.email')
                    ->label('Emails')
                    ->searchable()
                    ->limit(26)
                
                    ->toggleable(isToggledHiddenByDefault: False),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em') 
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: False)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\ServicosRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }    
}