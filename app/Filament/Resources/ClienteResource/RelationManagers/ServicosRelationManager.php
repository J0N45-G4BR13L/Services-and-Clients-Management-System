<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\ServicoStatus;
use Illuminate\Support\Facades\Auth;
use Leandrocfe\FilamentPtbrFormFields\Money;


class ServicosRelationManager extends RelationManager
{
    protected static string $relationship = 'servicos';

    protected static ?string $label = 'Serviço';

    protected static ?string $pluralModelLabel = 'Serviço';

  
    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('Serviços');
    }

    public function form(Form $form): Form
    {


        $loggedInUserId = Auth::id();
        return $form

            ->schema([

                Forms\Components\Hidden::make('user_id') 
                            ->default($loggedInUserId),
                
                Forms\Components\TextInput::make('titulo')
                    ->label('Título')
                    ->required()

                    ->maxLength(255)
                    ->columnSpan(['md' => 10])
                    ->dehydrateStateUsing(fn ($state) => ucwords($state)),
                
              
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
                    ->columnSpan(['md' => 10])
                    ->maxLength(2550),
                Forms\Components\FileUpload::make('arquivos')
                    ->multiple()
                    ->enableDownload()
                    ->visibility('public')
                    ->imagePreviewHeight('250')
                    ->preserveFilenames()
                    ->imageEditor()
                    ->downloadable()
                    ->enableOpen()
                    ->columnSpan(['md' => 10])

                

            ]);

    }

    public function table(Table $table): Table
    {

        
        return $table
            ->recordTitleAttribute('Serviços')
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}