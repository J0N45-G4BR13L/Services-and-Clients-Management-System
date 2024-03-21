<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use App\Models\Servico;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class NovosServicosChart extends ChartWidget
{
    protected static ?string $heading = 'Novos Serviços';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $loggedInUserId = Auth::id();

        $servicos = Servico::where('user_id', $loggedInUserId)
            ->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
            ->get();

        $data = $servicos->groupBy(function ($servico) {
            return $servico->created_at->format('Y-m');
        })->map->count();

        return [
            'datasets' => [
                [
                    'label' => 'Serviços',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
