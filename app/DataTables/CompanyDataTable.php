<?php

namespace App\DataTables;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CompanyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->editColumn('created_at', function (Company $model) {
                return $model->created_at->format('d/m/Y H:i:s'); // Formato de la fecha
            })
            ->editColumn('updated_at', function (Company $model) {
                return $model->updated_at->format('d/m/Y H:i:s'); // Formato de la fecha
            })
            ->addColumn('action', 'companies.action') // Agregar la columna de acciones
            ->setRowId('id'); // Establecer ID de fila
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Company $model): QueryBuilder
    {
        return $model->newQuery(); // Obtener empresas ordenadas por ID
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->parameters(["language" =>  ["url" =>"//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('companies-table')
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
            Column::make('name') 
                ->title('Nombre'),
            Column::make('address') 
                ->title('Dirección'),
            Column::make('phone') 
                ->title('Teléfono'),
            Column::make('email') 
                ->title('Correo Electrónico'),
            Column::make('created_at') 
                ->title('Fecha de Creación'),
            Column::make('updated_at') 
                ->title('Fecha de Actualización'),
            Column::make('action') 
                ->title('Acciones')
                ->orderable(false)
                ->searchable(false), 
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Companies_' . date('YmdHis');
    }
}
