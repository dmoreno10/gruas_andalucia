<?php

namespace App\DataTables;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VehiclesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'vehicles.action') // Aquí se espera que tengas un archivo `action.blade.php`
            ->editColumn('created_at', function(Vehicle $model) {
                return $model->created_at ? $model->created_at->format('d/m/Y H:i:s') : 'N/A';
            })
            ->rawColumns(['action']) // Permitir HTML en la columna
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Vehicle $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'asc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->parameters(['language' => ['url' => '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json']])
            ->responsive()
            ->setTableId('users-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->lengthChange();
    }
    
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('license_plate')->title('Matrícula'),
            Column::make('brand')->title('Marca'),
            Column::make('model')->title('Modelo'),
            Column::make('year')->title('Año'),
            Column::make('type')->title('Tipo'),
            Column::make('color')->title('Color'),
            Column::make('status')->title('Estado'),
            Column::make('created_at')->title('Fecha de llegada'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Vehicles_' . date('YmdHis');
    }
}
