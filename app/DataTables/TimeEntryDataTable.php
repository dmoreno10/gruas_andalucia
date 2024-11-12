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
        ->addColumn('total', function (TimeEntry $model) {
            if ($model->end_time) {
                $start = Carbon::parse($model->start_time);
                $end = Carbon::parse($model->end_time);

                // Calcular la diferencia en minutos
                $minutes = $start->diffInMinutes($end);

                // Convertir a horas y limitar a dos decimales
                $hours = $minutes / 60;
                return number_format($hours, 2);  // Redondear a dos decimales
            }
            return 0;
        })
        ->setRowId('id');
}


    public function query(TimeEntry $model): QueryBuilder
    {
        return $model->newQuery()->with('employee')->orderBy('id', 'desc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters(["language" =>  ["url" => "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('entries-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->lengthChange(false);
    }

    public function getColumns(): array
    {
        return [
            // Column::make('id')->title('ID'),
            Column::make('employee.name')->title('Empleado'),
            Column::make('start_time')->title('Inicio de Jornada'),
            Column::make('end_time')->title('Fin de Jornada'),
            Column::make('total')->title('Total (min)'),
        ];
    }

    protected function filename(): string
    {
        return 'TimeEntries_' . date('YmdHis');
    }
}
