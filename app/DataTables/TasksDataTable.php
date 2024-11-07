<?php

namespace App\DataTables;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TasksDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
{
    return (new EloquentDataTable($query))
        ->editColumn('created_at', function(Task $model) {
            return $model->created_at->format('d/m/Y H:i:s');
        })
        ->editColumn('updated_at', function(Task $model) {
            return $model->updated_at->format('d/m/Y H:i:s');
        })
        ->editColumn('time_minutes', function(Task $model) {
            $hours = floor($model->time_minutes / 60);
            $minutes = $model->time_minutes % 60;
            return "{$hours} hora(s) y {$minutes} minuto(s)";
        })
        ->addColumn('action', 'tasks.action') // Asegúrate que la vista `tasks.action` está disponible
        ->rawColumns(['action'])
        ->setRowId('id');
}


    /**
     * Get the query source of dataTable.
     */
    public function query(Task $model): QueryBuilder
    {
        return $model->newQuery()->with('employee')->orderBy('id', 'asc'); // Asegúrate de incluir la relación
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns([
                Column::make('employee_id') // ID del Empleado
                    ->title('Empleado')
                    ->searchable(true),
                Column::make('description') // Descripción de la tarea
                    ->title('Descripción')
                    ->searchable(true),
                Column::make('points') // Puntos de la tarea
                    ->title('Puntos')
                    ->searchable(true),
                Column::make('time_minutes') // Tiempo en minutos
                    ->title('Tiempo (minutos)')
                    ->searchable(true),
                Column::computed('action') // Columna de acciones
                    ->title('Acciones')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            ])
            ->parameters([
                'language' => ['url' => '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'],
                'dom' => 'Bfrtip', // Configuración para el DOM
                'order' => [[1, 'asc']], // Ordenar por la primera columna
                'select' => 'single', // Estilo de selección
                'buttons' => [
                    Button::make('excel'),
                    Button::make('csv'),
                    Button::make('pdf'),
                    Button::make('print'),
                    Button::make('reset'),
                    Button::make('reload')
                ]
            ]);
    }


    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('employee_id')->title('Empleado')->searchable(true),
            Column::make('description')->title('Descripción')->searchable(true),
            Column::make('points')->title('Puntos')->searchable(true),
            Column::make('time_minutes')->title('Tiempo (minutos)')->searchable(true),
            Column::computed('action')->title('Acciones')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Tasks_' . date('YmdHis');
    }
}
