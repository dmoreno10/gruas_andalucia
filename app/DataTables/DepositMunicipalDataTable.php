<?php

namespace App\DataTables;

use App\Models\MunicipalDeposit;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;

class DepositMunicipalDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function (MunicipalDeposit $model) {
                // Asegúrate de que el estado esté correctamente representado.
                return $model->status === 1 ? 'Activo' : 'Inactivo';
            })
            ->addColumn('action', 'municipal-deposit.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @param MunicipalDeposit $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MunicipalDeposit $model)
    {
       
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->parameters(["language" =>  ["url" =>"//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])

            ->responsive()
            ->setTableId('municipal_deposit-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->lengthChange();
}

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Nombre'),
            Column::make('direction')->title('Dirección'),
            Column::make('town')->title('Ciudad'), 
            Column::make('status')->title('Estado'),
            Column::make('phone')->title('Teléfono'),
            Column::make('mobile_phone')->title('Móvil'),
            Column::computed('action')
            ->title('Acciones')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
            
        ];
    }

    /**
     * Get the filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'DepositMunicipals_' . date('YmdHis');
    }
}
