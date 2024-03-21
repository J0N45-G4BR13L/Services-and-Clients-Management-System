<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use App\Models\Servico;

class StasOverview extends BaseWidget
{



    protected function getStats(): array

    {

        $loggedInUserId = Auth::id();
        $clientesCount = Cliente::where('user_id', $loggedInUserId)->count();
        $servicosActiveCount = Servico::where('user_id', $loggedInUserId)
                                ->where('status', 'Em andamento')
                                ->count();
        $servicosDoneCount = Servico::where('user_id', $loggedInUserId)
                                ->where('status', 'Concluído')
                                ->count();

        return [
            Stat::make('Clientes', $clientesCount),
            Stat::make('Serviços ativos',  $servicosActiveCount),
            Stat::make('Serviços concluídos', $servicosDoneCount),
        ];
    }
}
