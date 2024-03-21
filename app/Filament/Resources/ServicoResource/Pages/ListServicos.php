<?php

namespace App\Filament\Resources\ServicoResource\Pages;

use App\Filament\Resources\ServicoResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListServicos extends ListRecords
{   
    use ExposesTableToWidgets;

    protected static string $resource = ServicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ServicoResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            null => ListRecords\Tab::make('Todos'),
            'Em andamento' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'Em andamento')),
            'Concluído' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'Concluído')),
            'Interrompido' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'Interrompido')),
            'Suspenso' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'Suspenso')),
            'Cancelado' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'Cancelado')),
        ];
    }
}