<?php

namespace App\DataTables;

use App\Models\DocumentalGestion;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DocumentalGestionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))->addColumn('action', 'documents.action')->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DocumentalGestion $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->parameters(["language" => ["url" =>"//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('documentalgestion-table')
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
            Column::make('title')->title('Título'),
            Column::make('description')->title('Descripción'),
            Column::make('file_path')
                ->title('Archivo')
                ->render(function ($data) {
                    if (is_array($data)) {
                        $links = '';
                        foreach ($data as $file) {
                            $links .= '<a href="/storage/' . $file . '" target="_blank">Ver Archivo</a><br>';
                        }
                        return $links;
                    }
                }),
            Column::make('created_at')->title('Fecha de Creación'),
            Column::computed('action')->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DocumentalGestion_' . date('YmdHis');
    }
}
