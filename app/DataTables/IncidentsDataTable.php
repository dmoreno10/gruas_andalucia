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
            ->parameters(["language" =>  ["url" =>"//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('incidents-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->lengthChange();
}

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id') 
                  ->title('ID'),
            Column::make('title') 
                  ->title('Título'),
            Column::make('status') 
                  ->title('Estado'),
            Column::make('created_at') 
                  ->title('Fecha Creación'),
            Column::computed('action') 
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
