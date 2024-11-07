<?php

namespace App\DataTables;

use App\Models\DocumentalGestion;
use App\Models\File;  // Usamos el modelo File
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FileDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
   public function dataTable(QueryBuilder $query): EloquentDataTable
        {
            return (new EloquentDataTable($query))
            ->addColumn('action', 'files.action')
            ->setRowId('id');

        }

        public function query(DocumentalGestion $model): QueryBuilder
        {
            return $model->newQuery()->orderBy('id', 'asc');  // Cambia File por DocumentalGestion
        }

        public function html(): HtmlBuilder
        {
            return $this->builder()
                        ->setTableId('files-table')
                        ->columns($this->getColumns())
                        ->minifiedAjax()
                        ->orderBy(1)
                        ->selectStyleSingle()
                        ->buttons([
                            Button::make('excel'),
                            Button::make('csv'),
                            Button::make('pdf'),
                            Button::make('print'),
                            Button::make('reset'),
                            Button::make('reload')
                        ]);
        }

        public function getColumns(): array
        {
            return [
                Column::make('file_name')->title('Nombre del Archivo'),
                Column::make('mime_type')->title('Tipo'),
                Column::make('created_at')->title('Fecha de Creación'),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center')
                    ->title('Acciones'),

            ];
        }

        protected function filename(): string
        {
            return 'Archivos_' . date('YmdHis');
        }
}
