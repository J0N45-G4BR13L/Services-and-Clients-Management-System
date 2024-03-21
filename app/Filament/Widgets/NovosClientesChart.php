<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;

class NovosClientesChart extends ChartWidget
{
    protected static ?string $heading = 'Novos clientes';
    protected static ?int $sort = 1;

    public function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $loggedInUserId = Auth::id();

        $clientes = Cliente::where('user_id', $loggedInUserId)
            ->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
            ->get();

        $data = $clientes->groupBy(function ($cliente) {
            return $cliente->created_at->format('Y-m');
        })->map->count();

        return [
            'datasets' => [
                [
                    'label' => 'Clientes',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys(),
        ];
    }
}
