<?php

namespace App\DataTables;

use App\Models\TimeEntry; // Asegúrate de usar el modelo correcto
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TimeEntryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
{
    return (new EloquentDataTable($query))
        ->editColumn('start_time', function (TimeEntry $model) {
            return Carbon::parse($model->start_time)->setTimezone('Europe/Madrid')->format('d/m/Y H:i:s');
        })
        ->editColumn('ended_at', function (TimeEntry $model) {
            return $model->ended_at ? Carbon::parse($model->ended_at)->setTimezone('Europe/Madrid ')->format('d/m/Y H:i:s') : 'N/A';
        })
        ->addColumn('total', function (TimeEntry $model) {
            if ($model->ended_at) {
                $start = Carbon::parse($model->start_time);
                $end = Carbon::parse($model->ended_at);
                return $start->diffInMinutes($end);
            }
            return 0;
        })
        ->setRowId('id');
}


    public function query(TimeEntry $model): QueryBuilder
    {
        // Obtener todas las entradas de tiempo ordenadas por ID
        return $model->newQuery()->with('employee')->orderBy('id', 'asc');
    }

    public function html()
    {
        return $this->builder()
            ->columns([
                Column::make('id')->title('ID'),
                Column::make('employee.name')->title('Empleado'),
                Column::make('start_time')->title('Inicio de Jornada'),
                Column::make('ended_at')->title('Fin de Jornada'),
                Column::make('total')->title('Total (min)'),
                Column::make('total_extra')->title('Total Extra (horas)'),
            ])
            ->parameters([
                'dom' => 'Bfrtip', // Personalización de los botones y la vista
                'pageLength' => 10, // Número de filas por página
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('employee.name')->title('Empleado'),
            Column::make('start_time')->title('Inicio de Jornada'),
            Column::make('ended_at')->title('Fin de Jornada'),
            Column::make('total')->title('Total (min)'),
            Column::make('total_extra')->title('Total Extra (horas)'),
        ];
    }

    protected function filename(): string
    {
        return 'TimeEntries_' . date('YmdHis');
    }
}
