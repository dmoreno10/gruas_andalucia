<?php

namespace App\DataTables;

use App\Models\Incident;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IncidentsDataTable extends DataTable
{/**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'incidents.action')
            ->editColumn('created_at', function(Incident $model) {
                return $model->created_at->format('d/m/Y H:i:s');
            })
            ->addColumn('status_icon', function(Incident $model) {
                switch ($model->status) {
                    case 'abierto':
                        return '<i class="fas fa-arrow-up" title="Abierto" style="color: orange;"></i>';
                    case 'cerrado':
                        return '<i class="fas fa-check-circle" title="Cerrado" style="color: green;"></i>';
                    case 'en_progreso':
                        return '<i class="fas fa-exclamation-circle" title="En Progreso" style="color: blue;"></i>';
                   }
            })
            ->rawColumns(['status_icon','action']) // Permitir HTML en la columna
            ->addColumn('action', 'incidents.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Incident $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'asc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->columns([
                // Otras columnas...
                Column::make('title')->title('Título'),
                Column::make('status')->title('Estado'),
                Column::make('status_icon')->title('Icono')->orderable(false)->searchable(false), // Añadir esta línea
                Column::make('created_at')->title('Fecha de Creación'),
                Column::computed('action')->title('Acciones')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            ])
            ->parameters([
                'dom' => 'Bfrtip',
                // Otras configuraciones...
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id') // ID del Incidente
                  ->title('ID'),
            Column::make('title') // Descripción o Título del Incidente
                  ->title('Título'),
            Column::make('status') // Estado del Incidente
                  ->title('Estado'),
            Column::make('created_at') // Fecha de Creación
                  ->title('Fecha Creación'),
            Column::computed('action') // Columna de acciones
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Incidents_' . date('YmdHis');
    }
}
