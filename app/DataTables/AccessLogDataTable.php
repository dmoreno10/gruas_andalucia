<?php

namespace App\DataTables;

use App\Models\AccessLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AccessLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user', function ($log) {
                return $log->user ? $log->user->name : 'Invitado';
            })
            ->editColumn('created_at', function(AccessLog $model) {
                return $model->created_at->format('d/m/Y H:i:s');
            })
            ->addColumn('status', function ($log) {
                return ucfirst($log->status); // Capitalizar el estado de acceso
            })
            ->addColumn('action', 'accesslog.action') // Esto es para acciones como editar o eliminar
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AccessLog $model): QueryBuilder
    {
        // Recuperamos los registros de acceso, con la relación con el usuario.
        return $model->newQuery()->with('user')->orderBy('id', 'asc'); // Eager loading de la relación con el modelo User
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('accesslog-table') // ID de la tabla
                    ->columns($this->getColumns()) // Definimos las columnas
                    ->minifiedAjax() // Carga los datos mediante AJAX
                    ->orderBy(1) // Ordenamos por la primera columna (ID)
                    ->selectStyleSingle()
                    ->buttons([ // Botones de exportación
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('action') // Columna para las acciones (editar/eliminar)
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

            Column::make('id'), // ID del acceso
            Column::make('user'), // Usuario asociado al acceso
            Column::make('ip_address')->title('IP Address'), // Dirección IP
            Column::make('user_agent')->title('User Agent'), // User agent del acceso
            Column::make('status')->title('Status'), // Estado de acceso
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AccessLog_' . date('YmdHis');
    }
}
