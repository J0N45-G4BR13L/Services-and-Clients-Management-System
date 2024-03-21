<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\CreateAction;
use Filament\Resources\Action;
use App\Filament\Resources\Widgets\StatsOverview;
use App\Enums\ServicoStatus;
use App\Providers\AppServiceProvider;
use App\Filament\Resources\ServicoResource\Pages;
use App\Filament\Resources\ServicoResource\RelationManagers;
use App\Models\Servico;
use Filament\Forms;
use Filament\Support\RawJs;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Cep;



class ServicoResource extends Resource
{
    protected static ?string $model = Servico::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Serviço';

    protected static ?string $pluralModelLabel = 'Serviços';

    public static function form(Form $form): Form
    {

        $loggedInUserId = Auth::id();

        return $form

        ->schema([
            Forms\Components\Group::make()
        
            ->schema([
                Forms\Components\Hidden::make('user_id') 
                            ->default($loggedInUserId),

                Forms\Components\Card::make()

                    ->schema([
                        
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título')
                            ->required()
    
                            ->maxLength(255)
                            ->columnSpan(['md' => 10])
                            ->dehydrateStateUsing(fn ($state) => ucwords($state)),
                        Forms\Components\Select::make('cliente_id')
                      
                            ->searchable()
                            ->preload()
                            ->relationship('cliente', 'nome', function ($query) use ($loggedInUserId) {
                                $query->whereHas('user', function ($userQuery) use ($loggedInUserId) {
                                    $userQuery->where('id', $loggedInUserId);
                                });
                            })
                            ->label('Cliente')
                            ->placeholder('Selecione um cliente')
                            ->columnSpan(['md' => 10])
                            ->required()
                            ->createOptionForm([
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
                            
                            ])

                            ->editOptionForm([
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
                            
                            ]),
                          
                        Forms\Components\Select::make('status')
                            ->options(ServicoStatus::class)
                            ->columnSpan(['md' => 5])
                            ->required()
                            ->default('Em andamento')
                            ->native(false),

                        Money::make('preco')
                            ->label('Preço')
                            ->columnSpan(['md' => 5]),
                        
                        Forms\Components\MarkdownEditor::make('descricao')
                            ->label('Descrição')
                            ->live(onBlur: true)
                            ->columnSpan(['md' => 10]),
                        Forms\Components\FileUpload::make('arquivos')
                            ->multiple()
                            ->enableDownload()
                            ->imagePreviewHeight('250')
                            ->preserveFilenames()
                            ->imageEditor()
                            ->downloadable()
                            ->enableOpen()
                            ->columnSpan(['md' => 10])
            
                        

                    ])->columns(['md' => 10]),

            ])->columnSpan(span: 'full')

        ]);





            
   
    }

    public static function table(Table $table): Table
    {

        $loggedInUserId = Auth::id(); 

        return $table
            
            ->modifyQueryUsing(function (Builder $query) use ($loggedInUserId) {
                $query->whereHas('cliente', function ($query) use ($loggedInUserId) {
                    $query->where('user_id', $loggedInUserId);
                });
            })

            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->wrap()
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->label('Cliente')
                    ->limit(20)
                    ->searchable()
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            //     Tables\Actions\Action::make('Download PDF')
            //         ->label('Download PDF')
            //         ->icon('heroicon-o-document-arrow-down')
            //         ->url(fn (Servico $record) => url("/pdf/{$record->id}"))
            //         ->openUrlInNewTab(),
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

    public static function getDetailsFormSchema(): array
    {
        return [
            //
        ];
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    // public static function getWidgets(): array {
    //     return [
    //         StatsOverview::class,
    //     ];
    // }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicos::route('/'),
            'create' => Pages\CreateServico::route('/create'),
            'edit' => Pages\EditServico::route('/{record}/edit'),
        ];
    }
}